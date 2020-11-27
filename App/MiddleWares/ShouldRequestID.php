<?php

namespace App\MiddleWares;

use App\Library\Exception;
use Dumb\DumbMiddleware;
use Dumb\Response;
use Psr\Http\Message\ServerRequestInterface;

class ShouldRequestID extends DumbMiddleware
{
    public function check(ServerRequestInterface $request): void
    {
        $queryParams = $request->getQueryParams();
        if (!isset($queryParams['id']) || ($queryParams['id']) <= 0) {
            throw new Exception('bad id in query params: ' . $queryParams['id'] ?? 'not set', Response::BAD_REQUEST);
        }
    }
}
