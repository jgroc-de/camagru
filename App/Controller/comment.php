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
    /** @var CommentManager $commentManager */
    private $commentManager;

    /** @var UserManager $userManager */
    private $userManager;

    /** @var MailManager $mailManager */
    private $mailManager;

    public function __construct(array $container, string $method, int $code = 200)
    {
        $this->method = $method;
        $this->code = $code;
        $this->commentManager = $container['comment']($container);
        $this->userManager = $container['user']($container);
        $this->mailManager = $container['mail']();
    }

    public function get()
    {
        $this->response['comments'] = $this->commentManager->getComments($_GET['id'])->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function put()
    {
        $this->response['comments'] = $this->commentManager->getLastComments($_GET['id'])->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function post()
    {
        $id = $_GET['id'];
        $comment = $this->commentManager->addComment($id);
        $this->sendUserNotification($id);
        $this->response['comment'] = $comment;
        $this->code = Response::CREATED;
    }

    public function delete()
    {
        $this->commentManager->deleteComment($_GET['id']);
        $this->response['status'] = 'deleted';
    }

    public function patch()
    {
        $this->commentManager->updateComment($_GET['id'], $_POST['comment']);
        $this->response['flash'] = 'updated!';
    }

    private function sendUserNotification($id)
    {
        $user = $this->userManager->getUserByImgId($id);
        if ($user['alert']) {
            $this->mailManager->sendCommentMail($user);
        }
    }
}
