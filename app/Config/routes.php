<?php

use Dumb\Dumb;

/**
 * bakaDo.
 * declare GET and POST routes
 * each routes names must be unique!!
 */
function bakado(Dumb $baka)
{
    $baka->bakado([
        'contact',
        'home' => [
            '',
            'b',
            'camagru',
            'error',
            'home',
            'picture',
        ],
		'filter',
        'login',
        'password',
        'pics',
        'picture',
        'setup',
        'user',
        'minimifier',
    ]);
}
