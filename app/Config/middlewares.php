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
            '/loginpost',
            '/signup',
            '/passwordpost and get',
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
            '/logindelete',
            '/camagru',
            '/comment',
            '/like',
            '/patchpic',
            '/postPic',
            '/deletePic',
            '/userget',
            '/userpost',
            '/password',
        ]
    );

    $baka->eatM(
        function (): int {
                    var_dump($GLOBAL);exit;
                    var_dump($_REQUEST);exit;
            if (!isset($_GET['id']) || !is_numeric($_GET['id']))
            {
                return 404;
            }
            $_GET['id'] = (int) $_GET['id'];

            return 0;
        },
        [
            '/picture',
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
            '/passwordGet',
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
            '/setup',
        ]
    );
}
