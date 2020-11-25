<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\CommentManager;
use App\Model\MailManager;
use App\Model\UserManager;
use Dumb\Patronus;
use Dumb\Response;

class comment extends Patronus
{
    /** @var CommentManager */
    private $commentManager;

    /** @var UserManager */
    private $userManager;

    /** @var MailManager */
    private $mailManager;

    public function __construct(string $method, int $code = 200)
    {
        parent::__construct($method, $code);
        $this->method = $method;
        $this->code = $code;
        $this->commentManager = Dumb::$container['comment'](Dumb::$container);
        $this->userManager = Dumb::$container['user'](Dumb::$container);
        $this->mailManager = Dumb::$container['mail']();
    }

    public function get(): void
    {
        $this->response['comments'] = $this->commentManager->getComments($_GET['id'])->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function put(): void
    {
        $this->response['comments'] = $this->commentManager->getLastComments($_GET['id'])->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function post(): void
    {
        $id = $_GET['id'];
        $comment = $this->commentManager->addComment($id);
        $this->sendUserNotification($id);
        $this->response['comment'] = $comment;
        $this->code = Response::CREATED;
    }

    public function delete(): void
    {
        $this->commentManager->deleteComment($_GET['id']);
        $this->response['status'] = 'deleted';
    }

    public function patch(): void
    {
        $this->commentManager->updateComment($_GET['id'], $_POST['comment']);
        $this->response['flash'] = 'updated!';
    }

    private function sendUserNotification(int $id): void
    {
        $user = $this->userManager->getUserByImgId($id);
        if ($user['alert']) {
            $this->mailManager->sendCommentMail($user);
        }
    }
}
