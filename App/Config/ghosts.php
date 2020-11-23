<?php

use App\MiddleWares\checkCommentProperty;
use App\MiddleWares\checkPictureProperty;
use App\MiddleWares\findPicture;
use Dumb\BakaDo;
use Dumb\Dumb;
use Dumb\IronWall;
use Dumb\Response;

/**
 * restrict access to some routes if datas does not exist in DB.
 */

/** @var Dumb $baka */
/** @var BakaDo $router */
/** @var array $container */

$middlewareHandler = new IronWall();
if ($router->isGhostMatch([
    'like' => [
        'delete',
        'post',
        'get',
    ],
])) {
    $middlewareHandler->addMiddleware(new findPicture($container['picture']($container)));
}

if ($router->isGhostMatch([
    'picture' => [
        'delete',
        'patch',
    ],
])) {
    $middlewareHandler->addMiddleware(new checkPictureProperty($container['picture']($container)));
}

if ($router->isGhostMatch([
    'comment' => [
        'delete',
        'patch',
    ],
])) {
    $middlewareHandler->addMiddleware(new checkCommentProperty($container['comment']($container)));
}

