<?php

declare(strict_types=1);

namespace App\Controller\get;

use Dumb\Dumbee;
use Dumb\Patronus;

class reinitGet extends Patronus
{
    public function trap(Dumbee $c)
    {
        $userManager = $c->user;
        $pseudo = $_GET['log'];

        if ($userManager->pseudoInDb($pseudo) && $userManager->checkValidationMail($pseudo, $_GET['key']))
        {
            $user = $userManager->getUser($pseudo);
            $_SESSION['pseudo'] = $user['pseudo'];
            $_SESSION['id'] = $user['id'];
            $_SESSION['alert'] = $user['alert'];
            $_SESSION['email'] = $user['email'];
        }
        else
        {
            $this->code = 400;
        }
    }

    public function bomb(array $options)
    {
        if ($this->code >= 400)
        {
            header('Location: /error');
        }
        else
        {
            header('Location: /');
        }
    }
}
