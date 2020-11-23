<?php


namespace Dumb;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

abstract class DumbMiddleware implements MiddlewareInterface
{
    /** @var DumbMiddleware */
    private $nextMiddleware;

    /** @var int */
    public $statusCode = Response::BAD_REQUEST;

    /** @var string */
    public $message = "";

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
        if (!$this->check($request)) {
            return new Response($this->statusCode, $this->message);
        }

        if ($this->nextMiddleware) {
            return $this->nextMiddleware->process($request, $handler);
        }

        return new Response();
    }

    abstract public function check(ServerRequestInterface $request): bool;
}