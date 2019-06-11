<?php

declare(strict_types=1);

namespace App\Controller;

use Dumb\Dumb;
use Dumb\Patronus;
use App\Library\Session;

class user extends Patronus
{
	private $userManager;

    public function get()
    {
        $this->response['settings'] = Session::getUser(); 
    }

    public function patch()
    {
		$user = new Session();
		$user->setFromPostData();

        if (!$this->userManager->updateUser($user)) {
			throw new \Exception('pseudo unavailable!', Dumb::BAD_REQUEST);
		}
		$user->setSession($user);
		$this->response['flash'] = 'Profil Succesfully updated';
	}

    public function post()
    {
		$user = new Session();
		$user->setFromPostData();
        $password = $_POST['password'];

		if (!$this->userManager->addUser($user, password_hash($password, PASSWORD_DEFAULT))) {
			throw new \Exception($_SESSION['flash']['fail'], Dumb::UNAUTHORIZED);
		}
		$this->container['mail']()->sendValidationMail($this->userManager->getUser($user));
		if (isset($_SESSION['flash']['success'])) {
			$this->response['flash'] = $_SESSION['flash']['success'];
		}
		unset($_SESSION['flash']);
	}

    public function delete()
    {
    	$this->userManager->deleteUser();
        session_unset();
        session_destroy();
    }

	protected function setup()
	{
        $this->userManager = $this->container['user']($this->container)->deleteUser();
	}
}
