<?php

declare(strict_types=1);

namespace App\Controller\post;

use Dumb\Patronus;

class settings extends Patronus
{
    public function trap(array $c)
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
}
