<?php

session_start();

/**
 * initialisation de variable pour app/view/template.php.
 */
$args = [
    'camagru' => '',
    'login' => isset($_SESSION['pseudo']),
    'title2' => '',
    'script' => '',
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
    'error' => [
        'code' => '',
        'message' => '',
    ],
];

require '../dumb/Dumb.php';
$api = new Dumb();
require '../app/routes.php';
require '../app/middlewares.php';
require '../app/forms.php';
require '../app/container.php';

$api->dumb($args);
