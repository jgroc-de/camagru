<?php

class UserManager extends SqlManager
{
    public function pseudoInDb($pseudo)
    {
        $request = '
			SELECT * 
			FROM users 
			WHERE pseudo= ?
		';

        return $this->sqlRequestFetch($request, array($pseudo));
    }

    public function checkValidationMail($login, $key)
    {
        $actif = false;

        $request = '
			SELECT validkey, actif
			FROM users
			WHERE pseudo = ?
		';
        if ($row = $this->sqlRequestFetch($request, array($login))) {
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
            if ($this->sqlRequest($request, array($login), true)) {
                $_SESSION['flash'] = ['success' => 'Votre compte a bien été activé'];
            } else {
                $_SESSION['flash'] = ['fail' => 'Proudly Fail!'];
            }
        } else {
            $_SESSION['flash'] = ['fail' => 'Votre compte ne peut, malheureusement, pas etre activé'];
        }

        return true;
    }

    //### About password_verify: it's a fuction from the standard library

    public function checklogin($pseudo, $pass)
    {
        if ($this->pseudoInDb($pseudo)) {
            $request = '
				SELECT * 
				FROM users
				WHERE pseudo = ?
			';
            $elmt = $this->sqlRequestFetch($request, array($pseudo));
            if ($elmt['actif'] && password_verify($pass, $elmt['passwd'])) {
                return true;
            } elseif (!$elmt['actif']) {
                $_SESSION['flash'] = ['fail' => 'compte inactif'];
            } else {
                $_SESSION['flash'] = ['fail' => 'mauvais mot de passe'];
            }
        } else {
            $_SESSION['flash'] = ['fail' => 'compte inexistant ou mauvais mot de passe'];
        }

        return false;
    }

    public function resetValidkey($login)
    {
        $key = md5(microtime(true) * 100000);

        $request = $this->container->db->prepare('UPDATE users SET validkey = ? WHERE pseudo = ?');

        return $request->execute(array($key, $login));
    }

    public function addUser($pseudo, $pass, $mail)
    {
        $valid = false;
        $key = md5(microtime(true) * 100000);
        if (!($this->pseudoInDb($pseudo))) {
            $request = '
				INSERT INTO users
				(pseudo, passwd, email, validkey)
				VALUES (?, ?, ?, ?)'
            ;
            $valid = $this->sqlRequest($request, array($pseudo, $pass, $mail, $key), true);
        } else {
            $_SESSION['flash'] = ['fail' => 'Pseudo déja pris, dsl…'];
        }

        return $valid;
    }

    public function getUser($pseudo)
    {
        $request = '
			SELECT *
			FROM users
			WHERE pseudo = ?
		';

        return $this->sqlRequestFetch($request, array($pseudo));
    }

    public function getUserSettings($pseudo)
    {
        $request = '
			SELECT pseudo, email, alert
			FROM users
			WHERE pseudo = ?
		';

        return $this->sqlRequestFetch($request, array($pseudo));
    }

    public function getUserById($id)
    {
        $request = '
			SELECT *
			FROM users
			WHERE id = ?
		';

        return $this->sqlRequestFetch($request, array($id));
    }

    public function getUserByImgId($id)
    {
        $request = '
            SELECT *
            FROM img
            INNER JOIN users
            ON img.id_author = users.id
			WHERE img.id = ?
		';

        return $this->sqlRequestFetch($request, array($id));
    }

    public function updateUser($pseudo, $email, $alert)
    {
        $oldPseudo = $_SESSION['pseudo'];
        if ($pseudo != $oldPseudo && $this->pseudoInDb($pseudo)) {
            return false;
        } else {
            $request = $this->container->db->prepare('
                    UPDATE users
                    SET pseudo = :pseudo, email = :email, alert = :alert
                    WHERE pseudo = :login');
            $passwd = password_hash($passwd, PASSWORD_DEFAULT);
            $request->bindParam(':alert', $alert, PDO::PARAM_BOOL);
            $request->bindParam(':email', $email, PDO::PARAM_STR);
            $request->bindParam(':pseudo', $pseudo, PDO::PARAM_STR);
            $request->bindParam(':login', $oldPseudo, PDO::PARAM_STR);
            $request->execute();

            return true;
        }
    }

    public function updatePassword($passwd)
    {
        $request = $this->container->db->prepare('UPDATE users SET passwd = :pass  WHERE pseudo = :login');
        $passwd = password_hash($passwd, PASSWORD_DEFAULT);
        $request->bindParam(':pass', $passwd, PDO::PARAM_STR);
        $request->bindParam(':login', $_SESSION['pseudo'], PDO::PARAM_STR);
        $request->execute();
    }
}
