<?php

declare(strict_types=1);

namespace App\Controller;

use Dumb\Dumb;
use Dumb\Patronus;
use App\Library\Session;

class login extends Patronus
{
    protected function post()
    {
        $pseudo = $_POST['pseudo'];
        $password = $_POST['password'];

        if (!$this->userManager->checkLogin($pseudo, $password)) {
			throw new \Exception('Bad password or login', Dumb::UNAUTHORIZED);
		}
		$user = $this->userManager->getUser($pseudo);
		Session::setSession($user);
		$this->setResponse($pseudo);
	}

    protected function delete()
    {
        session_unset();
        session_destroy();
        $this->response['flash'] = 'See u soon!!';
    }

	protected function setup()
	{
		$this->userManager = $this->container['user']($this->container);
	}

	private function setResponse($pseudo)
	{
		$this->response = [
			'flash' => 'Welcome back '.$pseudo,
			'settings' => ['pseudo' => $pseudo],
		];
	}
}
