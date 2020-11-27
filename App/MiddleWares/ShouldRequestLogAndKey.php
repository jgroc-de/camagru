<?php

namespace App\MiddleWares;

use App\Library\Exception;
use Dumb\DumbMiddleware;
use Dumb\Response;
use Psr\Http\Message\ServerRequestInterface;

class ShouldRequestLogAndKey extends DumbMiddleware
{
    public function Check(ServerRequestInterface $request): void
    {
        $queryParams = $request->getQueryParams();
        if (!isset($queryParams['log'], $queryParams['key'])) {
            throw new Exception('key and log missing in request', Response::BAD_REQUEST);
        }
    }
}
