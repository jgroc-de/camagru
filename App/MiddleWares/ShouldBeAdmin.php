<?php


namespace App\MiddleWares;


use Dumb\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ShouldBeAdmin implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if ('troll2' !== $_SESSION['user']['pseudo']) {
            throw new \Exception('', Response::FORBIDDEN);
        }

        return $handler->handle($request);
    }
}