<?php

declare(strict_types=1);

namespace App\Controller;

use App\Library\Session;
use Dumb\Patronus;
use Dumb\Response;

class password extends Patronus
{
    private $userManager;

    protected function setup()
    {
        $this->userManager = $this->container['user']($this->container);
    }

    public function get()
    {
        $pseudo = $_GET['log'];
        if (!$this->userManager->pseudoInDb($pseudo)
            || !$this->userManager->checkValidationMail($pseudo, $_GET['key'])
        ) {
            throw new \Exception('password', Response::BAD_REQUEST);
        }
        $user = $this->userManager->getUser($pseudo);
        new Session($user);
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
            throw new \Exception('password', Response::NOT_FOUND);
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
}
