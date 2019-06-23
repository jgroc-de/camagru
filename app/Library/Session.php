<?php

declare(strict_types=1);

namespace App\Library;

class Session
{
    private $pseudo;
    private $id;
    private $alert;
    private $email;

    public function __construct($user = null)
    {
        if ($user) {
            $this->setSession($user);
        }
    }

    public function updateSession()
    {
        $_SESSION['id'] = $this->id;
        $_SESSION['user'] = [
            'pseudo' => $this->pseudo,
            'id' => $this->id,
            'alert' => $this->alert,
            'email' => $this->email,
        ];
    }

    public function setSession(array $user)
    {
        $_SESSION['id'] = $user['id'];
        $_SESSION['user'] = [
            'pseudo' => $user['pseudo'],
            'id' => $user['id'],
            'alert' => $user['alert'],
            'email' => $user['email'],
        ];
    }

    public function getSession()
    {
        if (isset($_SESSION['user'])) {
            return $_SESSION['user'];
        }

        return null;
    }

    public function setUserFromPostData()
    {
        $this->pseudo = $_POST['pseudo'];
        $this->email = $_POST['email'];
        $this->alert = isset($_POST['alert']) ? true : false;
        $this->id = isset($_SESSION['id']) ? $_SESSION['id'] : null;
    }

	public function getPseudo()
	{
		return $this->pseudo;
	}

	public function getEmail()
	{
		return $this->email;
	}

	public function getAlert()
	{
		return $this->alert;
	}

	public function setAlert(bool $alert)
	{
		$this->alert = $alert;
	}
}
