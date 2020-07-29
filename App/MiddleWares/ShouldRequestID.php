<?php


namespace App\MiddleWares;


use Dumb\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ShouldRequestID implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if (!isset($_GET['id']) || ($_GET['id']) <= 0) {
            throw new \Exception('bad request', Response::BAD_REQUEST);
        }

        return $handler->handle($request);
    }
}