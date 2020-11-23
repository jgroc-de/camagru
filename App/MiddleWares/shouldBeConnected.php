<?php

namespace App\MiddleWares;

use Dumb\DumbMiddleware;
use Dumb\Response;
use Psr\Http\Message\ServerRequestInterface;

class shouldBeConnected extends DumbMiddleware
{
    public function check(ServerRequestInterface $request)
    {
        if (!isset($_SESSION['user'])) {
            throw new \Exception('You should log in :)', Response::FORBIDDEN);
        }
    }
}
