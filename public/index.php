<?php

session_start();

require __DIR__.'/../vendor/autoload.php';

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

require '../Dumb/Dumb.php';
$baka = new Dumb\Dumb();
require '../app/routes.php';
require '../app/middlewares.php';
require '../app/forms.php';
require '../app/container.php';

$baka->kamehameha($args);
