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
        '/contact',
        '/home' => '/',
        '/home' => '/b',
        '/home' => '/camagru',
        '/home' => '/error',
        '/home' => '/picture',
        '/home',
        '/login',
        '/password',
        '/pics',
        '/picture',
        '/setup',
        '/user',
    ]);
}
