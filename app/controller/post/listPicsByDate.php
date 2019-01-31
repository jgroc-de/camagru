<?php

use Dumb\Dumbee;

/**
 * listpicsByDate.
 *
 * @param Dumbee $container
 * @param array  $options
 *
 * @return array $response
 */
function listpicsByDate(Dumbee $container, array $options)
{
    $pics = $container->picture->getPics(($_POST['start'] - 1) * 4);
    $code = empty($pics) ? 404 : 200;

    return [
        'pics' => $pics,
        'code' => $code,
        'start' => $_POST['start'] + 1,
        'url' => '/listPicsByDate',
    ];
}
