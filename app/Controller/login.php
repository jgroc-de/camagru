<?php

declare(strict_types=1);

namespace App\Controller;

use Dumb\Patronus;

class login extends Patronus
{
    protected function post()
    {
        $pseudo = $_POST['pseudo'];
        $password = $_POST['password'];
        $userManager = $this->container['user']($this->container);

        if ($userManager->checkLogin($pseudo, $password)) {
            $user = $userManager->getUser($pseudo);
            $_SESSION['pseudo'] = $user['pseudo'];
            $_SESSION['id'] = $user['id'];
            $_SESSION['alert'] = $user['alert'];
            $_SESSION['email'] = $user['email'];
            $this->response['flash'] = 'Welcome back '.$pseudo;
        } else {
            $this->code = 401;
            $this->response['flash'] = 'Bad password or login';
        }
    }

    protected function delete()
    {
        session_unset();
        session_destroy();
    }
}