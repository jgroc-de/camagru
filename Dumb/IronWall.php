<?php

declare(strict_types=1);

namespace Dumb;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * this is the middleware system.
 */
class IronWall implements RequestHandlerInterface
{
    /** @var DumbMiddleware */
    private $middleware = null;

    public function addMiddleware(DumbMiddleware $middleware): void
    {
        if (null === $this->middleware) {
            $this->middleware = $middleware;
        } else {
            $this->middleware->setNextMiddleware($middleware);
        }
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        if (null === $this->middleware) {
            return new Response();
        }

        return $this->middleware->process($request, $this);
    }
}
