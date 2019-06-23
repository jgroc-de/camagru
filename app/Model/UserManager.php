<?php

namespace App\Model;

use Dumb\Response;
use App\Library\Session;

class UserManager extends SqlManager
{
    public function pseudoInDb(string $pseudo)
    {
        $request = '
			SELECT id 
			FROM users 
			WHERE pseudo = ?
		';

        return $this->sqlRequestFetch($request, [$pseudo]);
    }

    public function checkValidationMail(string $login, string $key)
    {
        $actif = false;

        $request = '
			SELECT validkey, actif
			FROM users
			WHERE pseudo = ?
		';
        $keyBd = '';
        if ($row = $this->sqlRequestFetch($request, [$login])) {
            $actif = $row['actif'];
            $keyBd = $row['validkey'];
        }
        if ($actif) {
            $_SESSION['flash'] = ['success' => 'Votre compte est déja actif'];
        } elseif (!strcmp($key, $keyBd)) {
            $request = '
				UPDATE users
				SET actif = true 
				WHERE pseudo = ?
			';
            if ($this->sqlRequest($request, [$login], true)) {
                $_SESSION['flash'] = ['success' => 'Votre compte a bien été activé'];
            } else {
                throw new \Exception('Proudly Fail!', Response::BAD_REQUEST);
            }
        } else {
            throw new \Exception('Votre compte ne peut, malheureusement, pas etre activé', Response::BAD_REQUEST);
        }

        return true;
    }

    //### About password_verify: it's a function from the standard library

    public function checklogin(string $pseudo, string $pass)
    {
        if ($this->pseudoInDb($pseudo)) {
            $request = '
				SELECT *
				FROM users
				WHERE pseudo = ?
			';
            $user = $this->sqlRequestFetch($request, [$pseudo]);
            if ($user['actif'] && password_verify($pass, $user['passwd'])) {
                return true;
            }
            if (!$user['actif']) {
                throw new \Exception('Compte inactif!', Response::BAD_REQUEST);
            }

            throw new \Exception('Mauvais mot de passe!', Response::BAD_REQUEST);
        }

        throw new \Exception('compte inexistant ou mauvais mot de passe', Response::BAD_REQUEST);
    }

    public function resetValidkey(string $pseudo)
    {
        $key = md5((string) ((int) microtime(true) * 100000));
        $request = $this->db->prepare('UPDATE users SET validkey = ? WHERE pseudo = ?');

        return $request->execute([$key, $pseudo]);
    }

    public function addUser(Session $user, string $pass)
    {
        if ($this->pseudoInDb($user->getPseudo())) {
            throw new \Exception('Pseudo déjà pris, desl…!', Response::BAD_REQUEST);
        }
        $key = md5((string) ((int) microtime(true) * 100000));
        $request = '
				INSERT INTO users
				(pseudo, passwd, email, validkey)
				VALUES (?, ?, ?, ?)'
            ;

        return $this->sqlRequest($request, [$user->getPseudo(), $pass, $user->getEmail(), $key], true);
    }

    public function deleteUser()
    {
        $request = 'DELETE FROM users WHERE id = ?';
        $this->sqlRequestFetch($request, [(int) $_SESSION['id']]);
    }

    public function getUser(string $pseudo)
    {
        $request = '
			SELECT *
			FROM users
			WHERE pseudo = ?
		';

        return $this->sqlRequestFetch($request, [$pseudo]);
    }

    public function getUserByEmail(string $email)
    {
        $request = '
			SELECT *
			FROM users
			WHERE email = ?
		';

        return $this->sqlRequestFetch($request, [$email]);
    }

    public function getUserSettings(string $pseudo)
    {
        $request = '
			SELECT pseudo, email, alert
			FROM users
			WHERE pseudo = ?
		';

        return $this->sqlRequestFetch($request, [$pseudo]);
    }

    public function getUserById(int $id)
    {
        $request = '
			SELECT *
			FROM users
			WHERE id = ?
		';

        return $this->sqlRequestFetch($request, [$id]);
    }

    public function getUserByImgId(int $id)
    {
        $request = '
            SELECT *
            FROM img
            INNER JOIN users
            ON img.id_author = users.id
			WHERE img.id = ?
		';

        return $this->sqlRequestFetch($request, [$id]);
    }

    public function updateUser(Session $user): bool
    {
        $oldPseudo = $_SESSION['user']['pseudo'];
		$pseudo = $user->getPseudo();
        if ($pseudo != $oldPseudo && $this->pseudoInDb($pseudo)) {
            return false;
        }
        $request = $this->db->prepare('
                    UPDATE users
                    SET pseudo = :pseudo, email = :email, alert = :alert
                    WHERE pseudo = :login');
		$alert = $user->getAlert();
		$email = $user->getEmail();	
        $request->bindParam(':alert', $alert, \PDO::PARAM_BOOL);
        $request->bindParam(':email', $email, \PDO::PARAM_STR);
        $request->bindParam(':pseudo', $pseudo, \PDO::PARAM_STR);
        $request->bindParam(':login', $oldPseudo, \PDO::PARAM_STR);
        $request->execute();

        return true;
    }

    public function updatePassword(string $passwd)
    {
        $request = $this->db->prepare('UPDATE users SET passwd = :pass  WHERE pseudo = :login');
        $passwd = password_hash($passwd, PASSWORD_DEFAULT);
        $request->bindParam(':pass', $passwd, \PDO::PARAM_STR);
        $request->bindParam(':login', $_SESSION['pseudo'], \PDO::PARAM_STR);
        $request->execute();
    }
}
