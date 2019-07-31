<?php

use Dumb\Dumb;
use Dumb\Response;

/**
 * shield.
 * restrict access to some Routes depending on some conditions.
 */
function shield(Dumb $baka)
{
    $baka->setMiddlewares(
        function () {
            if (isset($_SESSION['user'])) {
                session_unset();
                session_destroy();

                throw new \Exception('you were logged in :(', Response::BAD_REQUEST);
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
            if (!isset($_SESSION['user'])) {
                throw new \Exception('You should log in :)', Response::FORBIDDEN);
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
                'get',
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
        function () {
            if (!isset($_GET['id']) || ($_GET['id']) <= 0) {
                throw new \Exception('bad request', Response::BAD_REQUEST);
            }
        },
        [
            'picture' => [
                'get',
                'delete',
                'patch',
            ],
            'comment' => [
            ]
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
            if ('troll2' === $_SESSION['user']['pseudo']) {
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
