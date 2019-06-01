<?php

declare(strict_types=1);

namespace App\Controller;

use Dumb\Dumb;
use Dumb\Patronus;

class comment extends Patronus
{
    public function post()
    {
        $id = $_POST['id'];
        $user = $this->container['user']($this->container)->getUserByImgId($id);

        if (empty($user)) {
            throw new \Exception('comments', Dumb::NOT_FOUND);
        }
        $commentManager = $this->container['comment']($this->container);
        $commentManager->addComment();
        if ($user['alert']) {
            $this->container['mail']()->sendCommentMail($user);
        }
        $this->response = $commentManager->getCommentByImgId($id);
    }

    public function delete()
    {
        $commentManager = $this->container['comment']($this->container)->deleteComment($_GET['id']);
    }

    public function patch()
    {
        $commentManager = $this->container['comment']($this->container)->updateComment($_GET['id'], $_POST['comment']);
    }
}
