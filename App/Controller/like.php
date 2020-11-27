<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\LikesManager;
use Dumb\Dumb;
use Dumb\Patronus;
use Dumb\Request;
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
        $this->response = $this->likeManager->getLike((int) $request->getQueryParams()['id']);
    }

    public function delete(Request $request): void
    {
        $this->likeManager->deleteLike((int) $request->getQueryParams()['id']);
        $this->response = $this->likeManager->getLike((int) $request->getQueryParams()['id']);
        $this->response['flash'] = 'done :(';
    }

    public function post(Request $request): void
    {
        $this->likeManager->addLike((int) $request->getQueryParams()['id']);
        $this->response = $this->likeManager->getLike((int) $request->getQueryParams()['id']);
        $this->response['flash'] = 'Thx :)';
        $this->code = Response::CREATED;
    }
}
