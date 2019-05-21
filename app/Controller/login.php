<?php

declare(strict_types=1);

namespace App\Controller;

use Dumb\Patronus;

class login extends Patronus
{
    private function post(array $c)
    {
        $pseudo = $_POST['pseudo'];
        $password = $_POST['password'];
        $userManager = $c['user']($c);

        if ($userManager->checkLogin($pseudo, $password))
        {
            $user = $userManager->getUser($pseudo);
            $_SESSION['pseudo'] = $user['pseudo'];
            $_SESSION['id'] = $user['id'];
            $_SESSION['alert'] = $user['alert'];
            $_SESSION['email'] = $user['email'];
            $this->response['flash'] = 'Welcome back '.$pseudo;
        }
        else
        {
            $this->code = 401;
            $this->response['flash'] = 'Bad password or login';
        }
    }

    private function delete(array $c)
    {
        session_unset();
        session_destroy();
    }
}
