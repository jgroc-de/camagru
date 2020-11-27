<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\LikesManager;
use Dumb\Dumb;
use Dumb\Patronus;
use Dumb\Response;

class like extends Patronus
{
    /** @var LikesManager */
    private $likeManager;

    public function __construct(string $method, int $code = 200)
    {
        parent::__construct($method, $code);
        $this->likeManager = Dumb::getContainer()->get('like');
    }

    public function get(Request $request): void
    {
        $this->response = $this->likeManager->getLike((int) $_GET['id']);
    }

    public function delete(Request $request): void
    {
        $this->likeManager->deleteLike((int) $_GET['id']);
        $this->response = $this->likeManager->getLike((int) $_GET['id']);
        $this->response['flash'] = 'done :(';
    }

    public function post(Request $request): void
    {
        $this->likeManager->addLike((int) $_GET['id']);
        $this->response = $this->likeManager->getLike((int) $_GET['id']);
        $this->response['flash'] = 'Thx :)';
        $this->code = Response::CREATED;
    }
}
