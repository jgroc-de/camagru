<?php

namespace App\MiddleWares;

use Dumb\DumbMiddleware;
use Dumb\Response;
use Psr\Http\Message\ServerRequestInterface;
use App\Library\Exception;

class ShouldBeAdmin extends DumbMiddleware
{
    public function check(ServerRequestInterface $request): void
    {
        // for prod
        //return;
        if ('troll2' !== $_SESSION['user']['pseudo'] && !empty($_ENV['PROD'])) {
            throw new Exception('you are not admin!', Response::FORBIDDEN);
        }
    }
}
