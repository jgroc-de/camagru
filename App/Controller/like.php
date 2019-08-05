<?php

declare(strict_types=1);

namespace App\Controller;

use Dumb\Patronus;
use Dumb\Response;

class like extends Patronus
{
    private $likeManager;

    protected function setup()
    {
        $this->likeManager = $this->container['like']($this->container);
    }

    public function get()
    {
        $this->response = $this->likeManager->getLike((int) $_GET['id']);
    }

    public function delete()
    {
        $this->likeManager->deleteLike((int) $_GET['id']);
        $this->response = $this->likeManager->getLike((int) $_GET['id']);
        $this->response['flash'] = 'done :(';
    }

    public function post()
    {
        $this->likeManager->addLike((int) $_GET['id']);
        $this->response = $this->likeManager->getLike((int) $_GET['id']);
        $this->response['flash'] = 'Thx :)';
        $this->code = Response::CREATED;
    }
}
