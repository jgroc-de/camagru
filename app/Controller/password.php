<?php

declare(strict_types=1);

namespace App\Controller;

use Dumb\Patronus;

class password extends Patronus
{
    public function get()
    {
        $userManager = $this->container['user']($this->container);
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

    public function patch()
    {
        $this->container['user']($this->container)->updatePassword($_POST['password']);
        $this->response['flash'] = 'Password Succesfully updated';
    }

    public function post()
    {
        $userManager = $this->container['user']($this->container);
        $pseudo = $_POST['pseudo'];
        $user = $userManager->getUser($pseudo);
        if (!empty($user) && $userManager->resetValidkey($pseudo))
        {
            $this->container['mail']($this->container)->sendReinitMail($user);
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

    public function bomb(array $options)
    {
        if ($this->method == 'get')
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
        else
        {
            parent::bomb($options);
        }
    }
}
