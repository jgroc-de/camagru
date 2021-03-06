<?php

declare(strict_types=1);

namespace App\Controller;

use App\Library\MailSender;
use App\Model\CommentManager;
use App\Model\UserManager;
use Dumb\Dumb;
use Dumb\Patronus;
use Dumb\Request;
use Dumb\Response;

class comment extends Patronus
{
    /** @var CommentManager */
    private $commentManager;

    /** @var UserManager */
    private $userManager;

    /** @var MailSender */
    private $mailManager;

    public function __construct(string $method, int $code = 200)
    {
        parent::__construct($method, $code);
        $this->commentManager = Dumb::getContainer()->get('comment');
        $this->userManager = Dumb::getContainer()->get('user');
        $this->mailManager = Dumb::getContainer()->get('mail');
    }

    public function get(Request $request): void
    {
        $this->response['comments'] = $this->commentManager->getComments($request->getQueryParams()['id'])->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function put(Request $request): void
    {
        $this->response['comments'] = $this->commentManager->getLastComments($request->getQueryParams()['id'])->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function post(Request $request): void
    {
        $id = $request->getQueryParams()['id'];
        $comment = $this->commentManager->addComment($id);
        $this->sendUserNotification($id);
        $this->response['comment'] = $comment;
        $this->code = Response::CREATED;
    }

    public function delete(Request $request): void
    {
        $this->commentManager->deleteComment($request->getQueryParams()['id']);
        $this->response['status'] = 'deleted';
    }

    public function patch(Request $request): void
    {
        $this->commentManager->updateComment($request->getQueryParams()['id'], $_POST['comment']);
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
