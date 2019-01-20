<?php
session_start();

require '../dumb/dumb.php';
$api = new dumb();
require '../app/routes.php';

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
require '../app/container.php';
$api->dumb($args);
		/*$route = array(
			'signup' => 9,
			'login' => 9,
			'reinit' => 9,
			'camagru' => 6,
			'settings' => 10,
			'addComment' => 10,
			'addLike' => 10,
			'changeTitle' => 10,
			'createPic' => 10,
			'deletePic' => 10,
		);*/
