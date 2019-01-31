<?php

use Dumb\Dumbee;

/**
 * listpicsByLike.
 *
 * @param Dumbee $container
 * @param array  $options
 *
 * @return array $response
 */
function listpicsByLike(Dumbee $container, array $options)
{
    $pics = $container->picture->getPicsByLike(($_POST['start'] - 1) * 4);
    $code = empty($pics) ? 404 : 200;

    return [
        'pics' => $pics,
        'code' => $code,
        'start' => $_POST['start'] + 1,
        'url' => '/listPicsByDate',
    ];
}
