<?php

use \Dumb\Dumb;

/**
 * shield.
 * restrict access to some Routes depending on some conditions
 *
 * @param Dumb $baka
 */
function shield(Dumb $baka)
{
    $baka->eatM(
        function (): int {
            if (isset($_SESSION['pseudo']))
            {
                return 400;
            }

            return 0;
        },
        [
            '/login' => [
                'post'
            ],
            '/signup' => [
                'post'
            ],
            '/password' => [
                'post',
                'get',
            ],
        ]
    );

    $baka->eatM(
        function (): int {
            if (!isset($_SESSION['pseudo']))
            {
                return 403;
            }

            return 0;
        },
        [
            '/login' => [
                'delete'
            ],
            '/camagru' => [
                'get'
            ],
            '/comment' => [
                'post'
            ],
            '/like' => [
                'post'
            ],
            '/picture' => [
                'post',
                'patch',
                'delete',
            ],
            '/user' => [
                'get',
                'put',
                'patch',
                'delete',
            ],
            '/password' => [
                'patch'
            ],
        ]
    );

    $baka->eatM(
        function (): int {
            if (!isset($_GET['id']) || !is_numeric($_GET['id']))
            {
                return 404;
            }
            $_GET['id'] = (int) $_GET['id'];

            return 0;
        },
        [
            '/picture' => [],
        ]
    );

    $baka->eatM(
        function (): int {
            if (!isset($_GET['log'], $_GET['key']))
            {
                return 404;
            }

            return 0;
        },
        [
            '/password' => [
                'get',
            ],
        ]
    );

    $baka->eatM(
        function (): int {
            if ($_SESSION['pseudo'] !== 'troll2')
            {
                return 403;
            }

            return 0;
        },
        [
            '/setup' => [],
        ]
    );
}
