<?php

session_start();

//autoloader
require __DIR__.'/../vendor/autoload.php';
//Dumb Framework
require '../Dumb/Dumb.php';

//Dumb Framework is alive!!!
$baka = new Dumb\Dumb();

//require '../app/container.php';
equip($baka);

//require '../app/routes.php';
bakaDo($baka);

//require '../app/middlewares.php';
shield($baka);

//require '../app/forms.php';
trollBumper($baka);

//require '../app/ghosts.php';
incept($baka);

/**
 * initialisation de variable pour app/view/template.php.
 */
$args = [
    'header' => [
        '/common/header.php',
        '/form/loginView.html',
        '/form/reinitView.html',
        '/form/settingsView.html',
    ],
    'components' => [
        '/common/about.php',
        '/common/contact.php',
    ],
];

$baka->kamehameha($args);
