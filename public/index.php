<?php

session_start();

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

require '../dumb/Dumb.php';
$baka = new Dumb();
require '../app/routes.php';
require '../app/middlewares.php';
require '../app/forms.php';
require '../app/container.php';

$baka->kamehameha($args);
