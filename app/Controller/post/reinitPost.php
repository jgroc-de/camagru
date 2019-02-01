<?php

declare(strict_types=1);

namespace App\Controller\post;

use Dumb\Dumbee;
use Dumb\Patronus;

class reinitPost extends Patronus
{
    public function trap(Dumbee $c)
    {
        $userManager = $c->user;
        $pseudo = $_POST['pseudo'];
        $user = $userManager->getUser($pseudo);

        if (!empty($user) && $userManager->resetValidkey($pseudo))
        {
            $c->mail->sendReinitMail($user);
        }
        else
        {
            $this->code = 404;
        }
        if (isset($_SESSION['flash']))
        {
            $this->response['flash'] = $_SESSION['flash'];
        }
    }
}
