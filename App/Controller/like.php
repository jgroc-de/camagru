<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\LikesManager;
use Dumb\Patronus;
use Dumb\Response;

class like extends Patronus
{
    /** @var LikesManager */
    private $likeManager;

    public function __construct(array $container, string $method, int $code = 200)
    {
        $this->method = $method;
        $this->code = $code;
        $this->likeManager = $container['like']($container);
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
