<?php

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
    return [
        'pics' => $container->picture->getPics(($_POST['start'] - 1) * 4),
        'code' => 200,
        'start' => $_POST['start'] + 1,
        'url' => '/listPicsByDate',
    ];
}
