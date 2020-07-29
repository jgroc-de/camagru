<?php

namespace App\MiddleWares;

use Dumb\Response;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;

class shouldNotBeConnected implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if (isset($_SESSION['user'])) {
            session_unset();
            session_destroy();

            throw new \Exception('you were logged in :(', Response::BAD_REQUEST);
        }

        return $handler->handle($request);
    }
}