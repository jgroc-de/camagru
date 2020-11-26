<?php

namespace App\MiddleWares;

use Dumb\DumbMiddleware;
use Dumb\Response;
use Psr\Http\Message\ServerRequestInterface;

class ShouldBeAdmin extends DumbMiddleware
{
    public function check(ServerRequestInterface $request): void
    {
        // for prod
        //return;
        if ('troll2' !== $_SESSION['user']['pseudo'] && !empty($_ENV['PROD'])) {
            throw new \Exception('', Response::FORBIDDEN);
        }
    }
}
