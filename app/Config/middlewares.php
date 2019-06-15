<?php

use Dumb\Response;
use Dumb\Dumb;

/**
 * shield.
 * restrict access to some Routes depending on some conditions.
 */
function shield(Dumb $baka)
{
    $baka->setMiddlewares(
        function () {
            if (isset($_SESSION['pseudo'])) {
                session_unset();
                session_destroy();

                throw new \Exception('you were logged in', Response::BAD_REQUEST);
            }
        },
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
        function () {
            if (!isset($_SESSION['pseudo'])) {
                throw new \Exception('', Response::FORBIDDEN);
            }
        },
        [
            'login' => [
                'delete',
            ],
            'camagru' => [
                'get',
            ],
            'comment' => [
                'post',
            ],
            'like' => [
                'post',
            ],
            'picture' => [
                'post',
                'patch',
                'delete',
            ],
            'user' => [
                'get',
                'put',
                'patch',
                'delete',
            ],
            'password' => [
                'patch',
            ],
        ]
    );

    $baka->setMiddlewares(
        function () {
            if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
                throw new \Exception('bad request', Response::BAD_REQUEST);
            }
            $_GET['id'] = (int) $_GET['id'];
        },
        [
            'picture' => [],
        ]
    );

    $baka->setMiddlewares(
        function () {
            if (!isset($_GET['log'], $_GET['key'])) {
                throw new \Exception('bad request', Response::BAD_REQUEST);
            }
        },
        [
            'password' => [
                'get',
            ],
        ]
    );

    $baka->setMiddlewares(
        function () {
            if ('troll2' !== $_SESSION['pseudo']) {
                throw new \Exception('', Response::FORBIDDEN);
            }
        },
        [
            'setup' => [
                'post',
            ],
        ]
    );
}
