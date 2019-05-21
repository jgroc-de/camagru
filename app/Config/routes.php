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
        '/contact',
        '/error',
        '/home' => '/',
        '/home',
        '/pics',
        '/picture',
        '/reinit' => ['/validation'],
        '/reinit',
        '/setup',
        '/user',
    ]);
}
