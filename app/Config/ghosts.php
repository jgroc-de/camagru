<?php

use Dumb\Dumb;
use Dumb\Response;

/**
 * incept.
 * restrict access to some routes if datas does not exist in DB.
 *
 * @param Dumb $baka
 */
function incept(Dumb $baka)
{
    $baka->setGhostShield(
        function (array $c) {
            if (!($c['picture']($c)->picInDb($_GET['id']))) {
                throw new \Exception('Picture not found', Response::NOT_FOUND);
            }
        },
        [
            'like' => [
                'delete',
                'post',
                'get',
            ],
        ]
    );

    $baka->setGhostShield(
        function (array $c) {
            $pic = $c['picture']($c)->getPic($_GET['id']);

            if (empty($pic)) {
                throw new \Exception('Picture not found', Response::NOT_FOUND);
            }
            if ($_SESSION['id'] !== $pic['author_id']) {
                throw new \Exception('Picture not yours', Response::FORBIDDEN);
            }
        },
        [
            'picture' => [
                'delete',
                'patch',
            ],
        ]
    );

    $baka->setGhostShield(
        function (array $c) {
            $comment = $c['comment']($c)->getComment($_GET['id']);

            if (empty($comment)) {
                throw new \Exception('Comment not found', Response::NOT_FOUND);
            }
            if ($_SESSION['id'] !== $comment['author_id']) {
                throw new \Exception('Comment not yours', Response::FORBIDDEN);
            }
        },
        [
            'comment' => [
                'delete',
                'patch',
            ],
        ]
    );
}
