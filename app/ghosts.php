<?php

function hack($baka)
{
    $baka->eatG(
        function (array $c) {
            if (!($c['picture']->picInDb($_POST['id'])))
            {
                return 404;
            }

            return 0;
        },
        [
            '/addLike',
            '/changeTitle',
        ]
    );

    $baka->eatG(
        function (array $c) {
            $pic = $c['picture']->getPicByUrl($_POST['url']);

            if (empty($pic) || $_SESSION['id'] !== $pic['id_author'])
            {
                return 404;
            }
            $_POST['id'] = $pic['id'];

            return 0;
        },
        [
            '/deletePic',
        ]
    );
}
