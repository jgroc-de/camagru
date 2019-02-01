<?php

declare(strict_types=1);

namespace App\Controller\post;

use Dumb\Dumbee;
use Dumb\Patronus;

class signup extends Patronus
{
    public function trap(Dumbee $c)
    {
        $pseudo = $_POST['pseudo'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $userManager = $c->user;

        if ($userManager->addUser($pseudo, password_hash($password, PASSWORD_DEFAULT), $email))
        {
            $c->mail->sendValidationMail($userManager->getUser($pseudo));
            if (isset($_SESSION['flash']['success']))
            {
                $this->response['flash'] = $_SESSION['flash']['success'];
            }
            elseif (isset($_SESSION['flash']['fail']))
            {
                $this->response['code'] = 500;
                $this->response['flash'] = $_SESSION['flash']['fail'];
            }
            unset($_SESSION['flash']);
        }
        else
        {
            $this->response['code'] = 401;
            $this->response['flash'] = 'Bad password or login';
        }
    }
}
