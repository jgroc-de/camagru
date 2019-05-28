<?php

namespace App\Model;

class UserManager extends SqlManager
{
    public function pseudoInDb(string $pseudo)
    {
        $request = '
			SELECT id 
			FROM users 
			WHERE pseudo= ?
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
                $_SESSION['flash'] = ['fail' => 'Proudly Fail!'];
            }
        } else {
            $_SESSION['flash'] = ['fail' => 'Votre compte ne peut, malheureusement, pas etre activé'];
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
            $elmt = $this->sqlRequestFetch($request, [$pseudo]);
            if ($elmt['actif'] && password_verify($pass, $elmt['passwd'])) {
                return true;
            }
            if (!$elmt['actif']) {
                $_SESSION['flash'] = ['fail' => 'compte inactif'];
            } else {
                $_SESSION['flash'] = ['fail' => 'mauvais mot de passe'];
            }
        } else {
            $_SESSION['flash'] = ['fail' => 'compte inexistant ou mauvais mot de passe'];
        }

        return false;
    }

    public function resetValidkey(string $login)
    {
        $key = md5((string) ((int) microtime(true) * 100000));

        $request = $this->db->prepare('UPDATE users SET validkey = ? WHERE pseudo = ?');

        return $request->execute([$key, $login]);
    }

    public function addUser(string $pseudo, string $pass, string $mail)
    {
        if (!($this->pseudoInDb($pseudo))) {
            $key = md5((string) ((int) microtime(true) * 100000));
            $request = '
				INSERT INTO users
				(pseudo, passwd, email, validkey)
				VALUES (?, ?, ?, ?)'
            ;

            return $this->sqlRequest($request, [$pseudo, $pass, $mail, $key], true);
        }

        $_SESSION['flash'] = ['fail' => 'Pseudo déja pris, dsl…'];

        return false;
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

    public function updateUser(string $pseudo, string $email, bool $alert): bool
    {
        $oldPseudo = $_SESSION['pseudo'];
        if ($pseudo != $oldPseudo && $this->pseudoInDb($pseudo)) {
            return false;
        }
        $request = $this->db->prepare('
                    UPDATE users
                    SET pseudo = :pseudo, email = :email, alert = :alert
                    WHERE pseudo = :login');
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
