<?php

use \Dumb\Dumb;

/**
 * incept.
 * restrict access to some routes if datas does not exist in DB
 *
 * @param Dumb $baka
 */
function incept($baka)
{
    $baka->eatG(
        function (array $c): int {
            if (!($c['picture']($c)->picInDb($_POST['id'])))
            {
                return 404;
            }

            return 0;
        },
        [
            '/like',
            '/picturepatch',
        ]
    );

    $baka->eatG(
        function (array $c): int {
            $pic = $c['picture']($c)->getPicByUrl($_POST['url']);

            if (empty($pic) || $_SESSION['id'] !== $pic['id_author'])
            {
                return 403;
            }
            $_POST['id'] = (int)$pic['id'];

            return 0;
        },
        [
            '/picturedelete',
        ]
    );

    $baka->eatG(
        function (array $c): int {
            $pic = $c['picture']($c)->getPic($_POST['id']);

            if (empty($pic) || $_SESSION['pseudo'] !== $pic['pseudo'])
            {
                return 403;
            }

            return 0;
        },
        [
            '/picturepatch',
        ]
    );
}
