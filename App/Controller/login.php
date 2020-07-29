<?php

declare(strict_types=1);

namespace App\Controller;

use App\Library\Session;
use App\Model\UserManager;
use Dumb\Patronus;
use Dumb\Response;

class login extends Patronus
{
    /** @var UserManager */
    private $userManager;

    public function __construct(array $container, string $method, int $code = 200)
    {
        $this->method = $method;
        $this->code = $code;
        $this->userManager = $container['user']($container);
    }

    protected function post()
    {
        $pseudo = $_POST['pseudo'];
        $password = $_POST['password'];

        if (!$this->userManager->checkLogin($pseudo, $password)) {
            throw new \Exception('Bad password or login', Response::UNAUTHORIZED);
        }
        $user = $this->userManager->getUser($pseudo);
        new Session($user);
        $this->setResponse();
    }

    protected function delete()
    {
        session_unset();
        session_destroy();
        $this->response['flash'] = 'See u soon!!';
    }

    private function setResponse()
    {
        $this->response = [
            'flash' => 'Welcome back '.$_SESSION['user']['pseudo'],
            'settings' => [
                'pseudo' => $_SESSION['user']['pseudo'],
                'id' => $_SESSION['id'],
            ],
        ];
    }
}
