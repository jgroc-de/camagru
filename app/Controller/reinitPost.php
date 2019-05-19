<?php

declare(strict_types=1);

namespace App\Controller\Get;

use Dumb\Patronus;

class reinitPost extends Patronus
{
    public function trap(array $c)
    {
        $userManager = $c['user']($c);
        $pseudo = $_POST['pseudo'];
        $user = $userManager->getUser($pseudo);

        if (!empty($user) && $userManager->resetValidkey($pseudo))
        {
            $c['mail']($c)->sendReinitMail($user);
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
