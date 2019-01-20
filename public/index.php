<?php
session_start();

/**
 * initialisation de variable pour app/view/template.php
 */
$args = array(
    'camagru' => '',
    'login' => '',
    'title2' => '',
    'script' => '',
	'components' => [
		'/common/about.php',
		'/common/contact.php'
	],
	'error' => [
		'code' => '',
		'message' => ''
		]
);

require '../dumb/dumb.php';
$api = new dumb();
require '../app/routes.php';
require '../app/middlewares.php';
require '../app/container.php';

$api->dumb($args);
