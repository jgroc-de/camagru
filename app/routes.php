<?php

use Dumb\Dumb;

/**
 * bakaDo.
 * declare GET and POST routes
 * each routes names must be unique!!
 *
 * @param Dumb $baka
 */
function bakado(Dumb $baka)
{
    $baka->bakado([
        '/camagru' => '/b',
        '/camagru',
        '/error',
        '/home' => '/',
        '/home',
        '/pic',
        '/user',
        '/contact',
        '/setup',
        '/reinit' => ['/reinitGet', '/validation'],
        '/reinitPost',
    ]);
}
