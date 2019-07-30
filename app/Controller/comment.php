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
        $this->response['comments'] = $this->container['comment']($this->container)->getComments($_GET['id'])->fetchAll();
    }

    public function post()
    {
        $id = $_GET['id'];
        $user = $this->container['user']($this->container)->getUserByImgId($id);

        if (empty($user)) {
            throw new \Exception('comments', Response::NOT_FOUND);
        }
        $this->commentManager->addComment();
        if ($user['alert']) {
            $this->container['mail']()->sendCommentMail($user);
        }
        $this->response = $this->commentManager->getCommentByImgId($id);
        $this->code = Response::CREATED;
    }

    public function delete()
    {
        $this->commentManager->deleteComment($_GET['id']);
    }

    public function patch()
    {
        $this->commentManager->updateComment($_GET['id'], $_POST['comment']);
    }
}
