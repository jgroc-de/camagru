<?php

namespace Dumb;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

abstract class DumbMiddleware implements MiddlewareInterface
{
    /** @var int */
    public $statusCode = Response::BAD_REQUEST;

    /** @var string */
    public $message = '';
    /** @var DumbMiddleware */
    private $nextMiddleware;

    public function setNextMiddleware(DumbMiddleware $middleware)
    {
        if ($this->nextMiddleware) {
            $this->nextMiddleware->setNextMiddleware($middleware);
        } else {
            $this->nextMiddleware = $middleware;
        }
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            $this->check($request);
        } catch (\Exception $e) {
            return new Response($e->getCode(), $e->getMessage());
        }

        if ($this->nextMiddleware) {
            return $this->nextMiddleware->process($request, $handler);
        }

        return new Response();
    }

    abstract public function check(ServerRequestInterface $request);
}
