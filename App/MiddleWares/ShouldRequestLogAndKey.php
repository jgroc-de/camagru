<?php

namespace App\MiddleWares;

use Dumb\DumbMiddleware;
use Dumb\Response;
use Psr\Http\Message\ServerRequestInterface;

class ShouldRequestLogAndKey extends DumbMiddleware
{
    public function Check(ServerRequestInterface $request)
    {
        $queryParams = $request->getQueryParams();
        if (!isset($queryParams['log'], $queryParams['key'])) {
            throw new \Exception("", Response::BAD_REQUEST);
        }
    }
}
