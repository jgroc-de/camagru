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

    public function setNextMiddleware(DumbMiddleware $middleware): void
    {
        if (!empty($this->nextMiddleware)) {
            $this->nextMiddleware->setNextMiddleware($middleware);
        } else {
            $this->nextMiddleware = $middleware;
        }
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $response = Response::getInstance();
        try {
            $this->check($request);
        } catch (\Exception $e) {
            $response->setAll((int) $e->getCode(), $e->getMessage());
            return $response;
        }

        if (!empty($this->nextMiddleware)) {
            return $this->nextMiddleware->process($request, $handler);
        }

        return $response;
    }

    abstract public function check(ServerRequestInterface $request): void;
}
