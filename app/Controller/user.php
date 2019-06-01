<?php

declare(strict_types=1);

namespace App\Controller;

use Dumb\Dumb;
use Dumb\Patronus;

class user extends Patronus
{
    public function get()
    {
        $this->response['settings'] = [
            'pseudo' => $_SESSION['pseudo'],
            'email' => $_SESSION['email'],
            'alert' => $_SESSION['alert'],
        ];
    }

    public function patch()
    {
        $pseudo = $_POST['pseudo'];
        $email = $_POST['email'];
        $alert = isset($_POST['alert']) ? true : false;

        if ($this->container['user']($this->container)->updateUser($pseudo, $email, $alert)) {
            $_SESSION['pseudo'] = $pseudo;
            $_SESSION['alert'] = $alert;
            $_SESSION['email'] = $email;
            $this->response['flash'] = 'Profil Succesfully updated';
        } else {
            throw new \Exception('pseudo unavailable!', Dumb::BAD_REQUEST);
        }
    }

    public function post()
    {
        $pseudo = $_POST['pseudo'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $userManager = $this->container['user']($this->container);

        if ($userManager->addUser($pseudo, password_hash($password, PASSWORD_DEFAULT), $email)) {
            $this->container['mail']()->sendValidationMail($userManager->getUser($pseudo));
            if (isset($_SESSION['flash']['success'])) {
                $this->response['flash'] = $_SESSION['flash']['success'];
            } elseif (isset($_SESSION['flash']['fail'])) {
                throw new \Exception($_SESSION['flash']['fail'], Dumb::INTERNAL_SERVER_ERROR);
            }
            unset($_SESSION['flash']);
        } else {
            throw new \Exception($_SESSION['flash']['fail'], Dumb::UNAUTHORIZED);
        }
    }

    public function delete()
    {
        $userManager = $this->container['user']($this->container)->deleteUser();
        session_unset();
        session_destroy();
    }
}
