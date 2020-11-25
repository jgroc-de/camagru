<?php

declare(strict_types=1);

namespace App\Controller;

use App\Library\MailSender;
use App\Library\Session;
use App\Model\UserManager;
use Dumb\Dumb;
use Dumb\Patronus;
use Dumb\Response;

class user extends Patronus
{
    /** @var UserManager */
    private $userManager;
    /** @var MailSender */
    private $mailManager;

    public function __construct(string $method, int $code = 200)
    {
        parent::__construct($method, $code);
        $this->userManager = Dumb::getService('user');
        $this->mailManager = Dumb::getService('mail');
    }

    public function get(): void
    {
        $this->response['settings'] = (new Session())->getSession();
    }

    public function patch(): void
    {
        $user = new Session();
        $user->setUserFromPostData();

        if (!$this->userManager->updateUser($user)) {
            throw new \Exception('pseudo unavailable!', Response::BAD_REQUEST);
        }
        $user->updateSession();
        $this->response['flash'] = 'Profil Succesfully updated';
    }

    public function post(): void
    {
        $user = new Session();
        $user->setUserFromPostData();
        $password = $_POST['password'];

        if (false == $this->userManager->addUser($user, password_hash($password, PASSWORD_DEFAULT))) {
            throw new \Exception($_SESSION['flash']['fail'], Response::UNAUTHORIZED);
        }
        $this->mailManager->sendValidationMail($this->userManager->getUser($user->getPseudo()));
        if (isset($_SESSION['flash']['success'])) {
            $this->response['flash'] = $_SESSION['flash']['success'];
        }
        unset($_SESSION['flash']);
        $this->code = Response::CREATED;
    }

    public function delete(): void
    {
        $this->userManager->deleteUser();
        session_unset();
        session_destroy();
        $this->response['flash'] = 'Account successfully erased!';
    }
}
