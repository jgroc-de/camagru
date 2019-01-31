<?php

namespace App\Model;

class UserManager extends SqlManager
{
    /**
     * pseudoInDb.
     *
     * @param mixed $pseudo
     */
    public function pseudoInDb(string $pseudo)
    {
        $request = '
			SELECT * 
			FROM users 
			WHERE pseudo= ?
		';

        return $this->sqlRequestFetch($request, [$pseudo]);
    }

    /**
     * checkValidationMail.
     *
     * @param mixed $login
     * @param mixed $key
     */
    public function checkValidationMail(string $login, string $key)
    {
        $actif = false;

        $request = '
			SELECT validkey, actif
			FROM users
			WHERE pseudo = ?
		';
        if ($row = $this->sqlRequestFetch($request, [$login]))
        {
            $actif = $row['actif'];
            $keyBd = $row['validkey'];
        }
        if ($actif)
        {
            $_SESSION['flash'] = ['success' => 'Votre compte est déja actif'];
        }
        elseif (!strcmp($key, $keyBd))
        {
            $request = '
				UPDATE users
				SET actif = true 
				WHERE pseudo = ?
			';
            if ($this->sqlRequest($request, [$login], true))
            {
                $_SESSION['flash'] = ['success' => 'Votre compte a bien été activé'];
            }
            else
            {
                $_SESSION['flash'] = ['fail' => 'Proudly Fail!'];
            }
        }
        else
        {
            $_SESSION['flash'] = ['fail' => 'Votre compte ne peut, malheureusement, pas etre activé'];
        }

        return true;
    }

    //### About password_verify: it's a function from the standard library

    /**
     * checklogin.
     *
     * @param mixed $pseudo
     * @param mixed $pass
     */
    public function checklogin(string $pseudo, string $pass)
    {
        if ($this->pseudoInDb($pseudo))
        {
            $request = '
				SELECT * 
				FROM users
				WHERE pseudo = ?
			';
            $elmt = $this->sqlRequestFetch($request, [$pseudo]);
            if ($elmt['actif'] && password_verify($pass, $elmt['passwd']))
            {
                return true;
            }
            if (!$elmt['actif'])
            {
                $_SESSION['flash'] = ['fail' => 'compte inactif'];
            }
            else
            {
                $_SESSION['flash'] = ['fail' => 'mauvais mot de passe'];
            }
        }
        else
        {
            $_SESSION['flash'] = ['fail' => 'compte inexistant ou mauvais mot de passe'];
        }

        return false;
    }

    /**
     * resetValidkey.
     *
     * @param mixed $login
     */
    public function resetValidkey(string $login)
    {
        $key = md5(microtime(true) * 100000);

        $request = $this->container->db->prepare('UPDATE users SET validkey = ? WHERE pseudo = ?');

        return $request->execute([$key, $login]);
    }

    /**
     * addUser.
     *
     * @param mixed $pseudo
     * @param mixed $pass
     * @param mixed $mail
     */
    public function addUser(string $pseudo, string $pass, string $mail)
    {
        $valid = false;
        $key = md5(microtime(true) * 100000);
        if (!($this->pseudoInDb($pseudo)))
        {
            $request = '
				INSERT INTO users
				(pseudo, passwd, email, validkey)
				VALUES (?, ?, ?, ?)'
            ;
            $valid = $this->sqlRequest($request, [$pseudo, $pass, $mail, $key], true);
        }
        else
        {
            $_SESSION['flash'] = ['fail' => 'Pseudo déja pris, dsl…'];
        }

        return $valid;
    }

    /**
     * getUser.
     *
     * @param mixed $pseudo
     */
    public function getUser(string $pseudo)
    {
        $request = '
			SELECT *
			FROM users
			WHERE pseudo = ?
		';

        return $this->sqlRequestFetch($request, [$pseudo]);
    }

    /**
     * getUserSettings.
     *
     * @param mixed $pseudo
     */
    public function getUserSettings(string $pseudo)
    {
        $request = '
			SELECT pseudo, email, alert
			FROM users
			WHERE pseudo = ?
		';

        return $this->sqlRequestFetch($request, [$pseudo]);
    }

    /**
     * getUserById.
     *
     * @param mixed $id
     */
    public function getUserById(int $id)
    {
        $request = '
			SELECT *
			FROM users
			WHERE id = ?
		';

        return $this->sqlRequestFetch($request, [$id]);
    }

    /**
     * getUserByImgId.
     *
     * @param mixed $id
     */
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

    /**
     * updateUser.
     *
     * @param mixed $pseudo
     * @param mixed $email
     * @param mixed $alert
     */
    public function updateUser(string $pseudo, string $email, string $alert)
    {
        $oldPseudo = $_SESSION['pseudo'];
        if ($pseudo != $oldPseudo && $this->pseudoInDb($pseudo))
        {
            return false;
        }
        $request = $this->container->db->prepare('
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

    /**
     * updatePassword.
     *
     * @param mixed $passwd
     */
    public function updatePassword(string $passwd)
    {
        $request = $this->container->db->prepare('UPDATE users SET passwd = :pass  WHERE pseudo = :login');
        $passwd = password_hash($passwd, PASSWORD_DEFAULT);
        $request->bindParam(':pass', $passwd, \PDO::PARAM_STR);
        $request->bindParam(':login', $_SESSION['pseudo'], \PDO::PARAM_STR);
        $request->execute();
    }
}
