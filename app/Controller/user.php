<?php

declare(strict_types=1);

namespace App\Controller\Get;

use Dumb\Patronus;

class user extends Patronus
{
    public function get(array $c)
    {
        $this->response['settings'] = [
            'pseudo' => $_SESSION['pseudo'],
            'email' => $_SESSION['email'],
            'alert' => $_SESSION['alert'],
        ];
    }

    public function patch(array $c)
    {
        $c['user']($c)->updatePassword($_POST['password']);
        $this->response['flash'] = 'Password Succesfully updated';
    }

    public function put(array $c)
    {
        $pseudo = $_POST['pseudo'];
        $email = $_POST['email'];
        $alert = isset($_POST['alert']) ? true : false;

        if ($c['user']($c)->updateUser($pseudo, $email, $alert))
        {
            $_SESSION['pseudo'] = $pseudo;
            $_SESSION['alert'] = $alert;
            $_SESSION['email'] = $email;
            $this->response['flash'] = 'Profil Succesfully updated';
        }
        else
        {
            $response['code'] = 400;
            $response['flash'] = 'Pseudo unavailable!';
        }
    }

    public function post(array $c)
    {
        $pseudo = $_POST['pseudo'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $userManager = $c['user']($c);

        if ($userManager->addUser($pseudo, password_hash($password, PASSWORD_DEFAULT), $email))
        {
            $c['mail']()->sendValidationMail($userManager->getUser($pseudo));
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
            $this->code = 401;
            $this->response['flash'] = $_SESSION['flash']['fail'];
            unset($_SESSION['flash']);
        }
    }
}
