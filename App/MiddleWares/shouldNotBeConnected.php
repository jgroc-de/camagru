<?php

namespace App\MiddleWares;

use App\Library\Exception;
use Dumb\DumbMiddleware;
use Dumb\Response;
use Psr\Http\Message\ServerRequestInterface;

class shouldNotBeConnected extends DumbMiddleware
{
    public function check(ServerRequestInterface $request): void
    {
        if (isset($_SESSION['user'])) {
            session_unset();
            session_destroy();

            throw new Exception('you were logged in :(', Response::BAD_REQUEST);
        }
    }
}
