<?php

declare(strict_types=1);

namespace App\Controller;

use Dumb\Dumb;
use Dumb\Patronus;

class comment extends Patronus
{
	private $commentManager;

    public function post()
    {
        $id = $_POST['id'];
        $user = $this->container['user']($this->container)->getUserByImgId($id);

        if (empty($user)) {
            throw new \Exception('comments', Dumb::NOT_FOUND);
        }
        $this->commentManager->addComment();
        if ($user['alert']) {
            $this->container['mail']()->sendCommentMail($user);
        }
        $this->response = $this->commentManager->getCommentByImgId($id);
    }

    public function delete()
    {
        $this->commentManager->deleteComment($_GET['id']);
    }

    public function patch()
    {
        $this->commentManager->updateComment($_GET['id'], $_POST['comment']);
    }

	protected function setup()
	{
        $this->commentManager = $this->container['comment']($this->container);
	}
}
