<?php

declare(strict_types=1);

namespace App\Controller;

use App\Library\Exception;
use App\Library\Session;
use App\Model\UserManager;
use Dumb\Dumb;
use Dumb\Patronus;
use Dumb\Request;
use Dumb\Response;

class login extends Patronus
{
    /** @var UserManager */
    private $userManager;

    public function __construct(string $method, int $code = 200)
    {
        parent::__construct($method, $code);
        $this->userManager = Dumb::getContainer()->get('user');
    }

    public function post(Request $request): void
    {
        $pseudo = $_POST['pseudo'];
        $password = $_POST['password'];

        if (!$this->userManager->checkLogin($pseudo, $password)) {
            throw new Exception('Bad password or login', Response::UNAUTHORIZED);
        }
        $user = $this->userManager->getUser($pseudo);
        new Session($user);
        $this->setResponse();
    }

    public function delete(Request $request): void
    {
        session_unset();
        session_destroy();
        $this->response['flash'] = 'See u soon!!';
    }

    private function setResponse(): void
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
