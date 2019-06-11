<?php

declare(strict_types=1);

namespace App\Controller;

use Dumb\Dumb;
use Dumb\Patronus;
use App\Library\Session;

class password extends Patronus
{
	private $userManager;

    public function get()
    {
        $pseudo = $_GET['log'];
		if (!$this->userManager->pseudoInDb($pseudo)
			|| !$this->userManager->checkValidationMail($pseudo, $_GET['key'])
		) {
            throw new \Exception('password', Dumb::BAD_REQUEST);
		}
		$user = $this->userManager->getUser($pseudo);
		Session::setSession($user);
	}

	public function patch()
	{
		$this->userManager->updatePassword($_POST['password']);
        $this->response['flash'] = 'Password Succesfully updated';
    }

    public function post()
    {
        $pseudo = $_POST['pseudo'];
        $user = $this->userManager->getUser($pseudo);
		if (empty($user) || !$this->userManager->resetValidkey($pseudo)) {
			throw new \Exception('password', Dumb::NOT_FOUND);
		}
		$this->container['mail']($this->container)->sendReinitMail($user);
		if (isset($_SESSION['flash'])) {
            $this->response['flash'] = $_SESSION['flash'];
        }
    }

    public function bomb(array $options = null)
    {
        if ('get' !== $this->method) {
            parent::bomb($options);
		}
		if ($this->code >= 400) {
			header('Location: /error');
		} else {
			header('Location: /');
		}
	}

	protected function setup()
	{
        $this->userManager = $this->container['user']($this->container);
	}
}
