<?php

use App\MiddleWares\ShouldBeAdmin;
use App\MiddleWares\shouldBeConnected;
use App\MiddleWares\shouldNotBeConnected;
use App\MiddleWares\ShouldRequestID;
use App\MiddleWares\ShouldRequestLogAndKey;
use Dumb\BakaDo;
use Dumb\Dumb;
use Dumb\IronWall;


/**
 * restrict access to some Routes depending on some conditions.
 */

/** @var Dumb $baka */
/** @var BakaDo $router */

$middlewareHandler = new IronWall();
$baka->addMiddlewareHandlers($middlewareHandler);

$routes =  [
    'login' => [
        'post',
    ],
    'signup' => [
        'post',
    ],
    'password' => [
        'post',
        'get',
    ],
];
if ($router->isMiddleWareMatch($routes)) {
    $middlewareHandler->addMiddleware(new shouldNotBeConnected());
}

$routes = [
    'login' => [
        'delete',
    ],
    'camagru' => [
        'get',
    ],
    'comment' => [
        'post',
        'patch',
        'delete',
    ],
    'like' => [
        'post',
        'delete',
    ],
    'picture' => [
        'post',
        'patch',
        'delete',
    ],
    'user' => [
        'put',
        'patch',
        'delete',
    ],
    'password' => [
        'patch',
    ],
    'picturesByUser' => [
        'get',
    ],
];
if ($router->isMiddleWareMatch($routes)) {
    $middlewareHandler->addMiddleware(new shouldBeConnected());
}

$routes = [
    'picture' => [
        'get',
        'delete',
        'patch',
    ],
    'comment' => [
    ],
];
if ($router->isMiddleWareMatch($routes)) {
    $middlewareHandler->addMiddleware(new ShouldRequestID());
}

$routes = [
    'password' => [
        'get',
    ],
];
if ($router->isMiddleWareMatch($routes)) {
    $middlewareHandler->addMiddleware(new ShouldRequestLogAndKey());
}

$routes = [
    'setup' => [
        'post',
    ],
];
if ($router->isMiddleWareMatch($routes)) {
    $middlewareHandler->addMiddleware(new ShouldBeAdmin());
}
