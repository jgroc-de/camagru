<?php

declare(strict_types=1);

namespace App\Controller;

use App\Library\MailSender;
use App\Library\Session;
use App\Model\UserManager;
use Dumb\Dumb;
use Dumb\Patronus;
use Dumb\Response;

class password extends Patronus
{
    /** @var UserManager */
    private $userManager;
    /** @var MailSender */
    private $mailManager;

    public function __construct(string $method, int $code = 200)
    {
        parent::__construct($method, $code);
        $this->userManager = Dumb::getContainer()->get('user');
        $this->mailManager = Dumb::getContainer()->get('mail');
    }

    public function get(): void
    {
        $pseudo = $_GET['log'];
        if (!$this->userManager->pseudoInDb($pseudo)
            || !$this->userManager->checkValidationMail($pseudo, $_GET['key'])
        ) {
            throw new \Exception('password', Response::BAD_REQUEST);
        }
        $user = $this->userManager->getUser($pseudo);
        new Session($user);
    }

    public function patch(): void
    {
        $this->userManager->updatePassword($_POST['password']);
        $this->response['flash'] = 'Password Succesfully updated';
    }

    public function post(): void
    {
        $email = $_POST['email'];
        $user = $this->userManager->getUserByEmail($email);
        if (empty($user) || !$this->userManager->resetValidkey($user['pseudo'])) {
            throw new \Exception('password', Response::NOT_FOUND);
        }
        $this->mailManager->sendResetMail($user);
        if (isset($_SESSION['flash'])) {
            $this->response['flash'] = $_SESSION['flash'];
        }
    }

    public function bomb(): string
    {
        if ('get' !== $this->method) {
            return json_encode($this->response);
        }

        return json_encode([]);
    }
}
