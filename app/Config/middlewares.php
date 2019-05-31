<?php

use Dumb\Dumb;

/**
 * shield.
 * restrict access to some Routes depending on some conditions.
 *
 * @param Dumb $baka
 */
function shield(Dumb $baka)
{
    $baka->setMiddlewares(
        function () {
            if (isset($_SESSION['pseudo'])) {
                throw new \Exception('middle', 400);
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
                throw new \Exception('middle', 403);
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
                throw new \Exception('middle', 404);
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
                throw new \Exception('middle', 404);
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
                throw new \Exception('middle', 403);
            }
        },
        [
            'setup' => [
                'get',
            ],
        ]
    );
}
