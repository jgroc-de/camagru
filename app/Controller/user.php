<?php

declare(strict_types=1);

namespace App\Controller;

use App\Library\Session;
use Dumb\Patronus;
use Dumb\Response;

class user extends Patronus
{
    private $userManager;

    protected function setup()
    {
        $this->userManager = $this->container['user']($this->container);
    }

    public function get()
    {
        $this->response['settings'] = (new Session())->getSession();
    }

    public function patch()
    {
        $user = new Session();
        $user->setUserFromPostData();

        if (!$this->userManager->updateUser($user)) {
            throw new \Exception('pseudo unavailable!', Response::BAD_REQUEST);
        }
        $user->updateSession();
        $this->response['flash'] = 'Profil Succesfully updated';
    }

    public function post()
    {
        $user = new Session();
        $user->setUserFromPostData();
        $password = $_POST['password'];

        if (!$this->userManager->addUser($user, password_hash($password, PASSWORD_DEFAULT))) {
            throw new \Exception($_SESSION['flash']['fail'], Response::UNAUTHORIZED);
        }
        $this->container['mail']()->sendValidationMail($this->userManager->getUser($user->getPseudo()));
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
}
