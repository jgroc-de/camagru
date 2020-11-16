<?php

namespace App\MiddleWares;

use Dumb\DumbMiddleware;
use Dumb\Response;
use Psr\Http\Message\ServerRequestInterface;

class shouldNotBeConnected extends DumbMiddleware
{
    public function check(ServerRequestInterface $request)
    {
        if (isset($_SESSION['user'])) {
            session_unset();
            session_destroy();

            throw new \Exception('you were logged in :(', Response::BAD_REQUEST);
        }
    }
}
