<?php


namespace App\MiddleWares;


use Dumb\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class shouldBeConnected implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if (!isset($_SESSION['user'])) {
            throw new \Exception('You should log in :)', Response::FORBIDDEN);
        }

        return $handler->handle($request);
    }
}