<?php

namespace App\MiddleWares;

use Dumb\DumbMiddleware;
use Dumb\Response;
use Psr\Http\Message\ServerRequestInterface;
use App\Library\Exception;

class ShouldRequestID extends DumbMiddleware
{
    public function check(ServerRequestInterface $request): void
    {
        $queryParams = $request->getQueryParams();
        if (!isset($queryParams['id']) || ($queryParams['id']) <= 0) {
            throw new Exception('bad id in query params', Response::BAD_REQUEST);
        }
    }
}
