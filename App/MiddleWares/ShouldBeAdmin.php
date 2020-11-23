<?php

namespace App\MiddleWares;

use Dumb\DumbMiddleware;
use Dumb\Response;
use Psr\Http\Message\ServerRequestInterface;

class ShouldBeAdmin extends DumbMiddleware
{
    public function check(ServerRequestInterface $request): void
    {
        if ('troll2' !== $_SESSION['user']['pseudo']) {
            throw new \Exception('', Response::FORBIDDEN);
        }
    }
}
