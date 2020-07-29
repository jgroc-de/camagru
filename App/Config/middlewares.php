<?php

use App\MiddleWares\ShouldBeAdmin;
use App\MiddleWares\shouldBeConnected;
use App\MiddleWares\shouldNotBeConnected;
use App\MiddleWares\ShouldRequestID;
use App\MiddleWares\ShouldRequestLogAndKey;
use Dumb\Dumb;


/**
 * restrict access to some Routes depending on some conditions.
 */
/** @var Dumb $baka */
$baka->setMiddlewares(
    shouldNotBeConnected::class,
    [
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
    ]
);

$baka->setMiddlewares(
    shouldBeConnected::class,
    [
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
    ]
);

$baka->setMiddlewares(
    ShouldRequestID::class,
    [
        'picture' => [
            'get',
            'delete',
            'patch',
        ],
        'comment' => [
        ],
    ]
);

$baka->setMiddlewares(
    ShouldRequestLogAndKey::class,
    [
        'password' => [
            'get',
        ],
    ]
);

$baka->setMiddlewares(
    ShouldBeAdmin::class,
    [
        'setup' => [
            'post',
        ],
    ]
);
