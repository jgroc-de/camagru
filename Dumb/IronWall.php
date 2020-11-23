<?php

declare(strict_types=1);

namespace Dumb;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * this is the middleware system.
 */
class IronWall implements RequestHandlerInterface
{
    private $middlewares = [];

    public function add(string $middleware)
    {
        $this->middlewares[] = $middleware;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        if ($this->middlewares === []) {
            return new Response();
        }
        /** @var MiddlewareInterface $middleware */
        $middleware = array_shift($this->middlewares);

        try {
            return (new $middleware())->process($request, $this);
        } catch (\Exception $exception) {
            return new Response($exception->getCode());
        }
    }
}
