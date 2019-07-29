<?php

declare(strict_types=1);

namespace App\Controller;

use Dumb\Patronus;
use Dumb\Response;

class like extends Patronus
{
    private $pictureManager;

    public function delete()
    {
        $this->pictureManager->deleteLike((int)$_POST['id']);
    }

    protected function setup()
    {
        $this->pictureManager = $this->container['picture']($this->container);
    }

    public function post()
    {
        $this->response['likes_counter'] = $this->pictureManager->addlike($_POST['id']);
        if ($this->response['likes_counter'] < 0) {
            $this->response['flash'] = 'Already liked!';
        } else {
            $this->code = Response::CREATED;
        }
    }
}
