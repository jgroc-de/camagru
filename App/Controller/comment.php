<?php

declare(strict_types=1);

namespace App\Controller;

use Dumb\Patronus;
use Dumb\Response;

class comment extends Patronus
{
    private $commentManager;

    protected function setup()
    {
        $this->commentManager = $this->container['comment']($this->container);
    }

    public function get()
    {
        $this->response['comments'] = $this->container['comment']($this->container)->getComments($_GET['id'])->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function put()
    {
        $this->response['comments'] = $this->container['comment']($this->container)->getLastComments($_GET['id'])->fetchAll(\PDO::FETCH_ASSOC);
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
        $user = $this->container['user']($this->container)->getUserByImgId($id);
        if ($user['alert']) {
            $this->container['mail']()->sendCommentMail($user);
        }
    }
}
