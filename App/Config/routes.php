<?php

use Dumb\Dumb;

/**
 * bakaDo.
 * declare GET and POST routes
 * each routes names must be unique!!
 */
function bakado(Dumb $baka)
{
    $baka->setRoutes([
        'contact',
        'home' => [
            '',
            'b',
            'camagru',
            'error',
            'home',
        ],
        'filter',
        'login',
        'password',
        'pics' => [
            'picturesByDate',
            'picturesByLike',
            'picturesByUser',
        ],
        'picture',
        //'setup',
        'user',
        'minimifier',
        'comment',
        'like',
    ]);
}
