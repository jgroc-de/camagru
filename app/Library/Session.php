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

	public function setSession($user)
	{
		$_SESSION['user'] = [
			'pseudo' => $user['pseudo'],
			'id' => $user['id'],
			'alert' => $user['alert'],
			'email' => $user['email'],
		];
	}

	public function getSession($user)
	{
		return $_SESSION['user'];
	}

	public function setUserFromPostData()
	{
        $this->pseudo = $_POST['pseudo'];
        $this->email = $_POST['email'];
        $this->alert = isset($_POST['alert']) ? true : false;
		$this->id = $_SESSION['id'];
	}
}
