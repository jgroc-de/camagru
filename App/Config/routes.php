<?php

use Dumb\BakaDo;

/**
 * bakaDo.
 * declare GET and POST routes
 * each routes names must be unique!!
 */
$routes = [
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
    'setup',
    'user',
    'minimifier',
    'comment',
    'like',
    'admin',
];
