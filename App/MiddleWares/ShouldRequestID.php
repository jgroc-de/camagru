<?php

namespace App\MiddleWares;

use Dumb\DumbMiddleware;
use Dumb\Response;
use Psr\Http\Message\ServerRequestInterface;

class ShouldRequestID extends DumbMiddleware
{
    public function check(ServerRequestInterface $request): void
    {
        $queryParams = $request->getQueryParams();
        if (!isset($queryParams['id']) || ($queryParams['id']) <= 0) {
            throw new \Exception('', Response::BAD_REQUEST);
        }
    }
}
