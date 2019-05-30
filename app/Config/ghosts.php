<?php

use Dumb\Dumb;

/**
 * incept.
 * restrict access to some routes if datas does not exist in DB.
 *
 * @param Dumb $baka
 */
function incept($baka)
{
    $baka->setGhostShield(
        function (array $c) {
            if (!($c['picture']($c)->picInDb($_POST['id']))) {
                throw new \Exception("ghost", 404);
            }
        },
        [
            'like' => [
                'post',
            ],
        ]
    );

    //à modifier pour ne pas etre dépendant de l'url
    $baka->setGhostShield(
        function (array $c) {
            $pic = $c['picture']($c)->getPicByUrl($_POST['url']);

            if (empty($pic)) {
                throw new \Exception("ghost", 404);
            }
            if ($_SESSION['id'] !== $pic['id_author']) {
                throw new \Exception("ghost", 403);
            }
            $_POST['id'] = (int) $pic['id'];
        },
        [
            'picture' => [
                'delete',
            ],
        ]
    );

    $baka->setGhostShield(
        function (array $c) {
            $pic = $c['picture']($c)->getPic($_POST['id']);

            if (empty($pic)) {
                throw new \Exception("ghost", 404);
            }
            if ($_SESSION['pseudo'] !== $pic['pseudo']) {
                throw new \Exception("ghost", 403);
            }
        },
        [
            'picture' => [
                'patch',
            ],
        ]
    );
}
