<?php
session_start();

require '../app/config/env.php';
require '../app/container.php';

function autoload($class)
{
    require '../app/model/' . $class . '.php';
}

spl_autoload_register('autoload');

/**
 *  option 0: nothing
 *  option 1: must be logout
 *  option 2: must be login
 *  option 4: must be GET route
 *  option 8: must be POST route
 */
$route = array(
    'listPics' => 4,
    'listPicsByLike' => 4,
    'picture' => 4,
    'logout' => 6,
    'camagru' => 6,
    'signup' => 9,
    'login' => 9,
    'reinit' => 9,
    'settings' => 10,
    'addComment' => 10,
    'addLike' => 10,
    'changeTitle' => 10,
    'createPic' => 10,
    'deletePic' => 10,
    'setup' => 0,
    'st_camagru' => 0
);
$default = 'listPics';
/**
 * initialisation de variable pour app/view/template.php
 */
$options = array(
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

try
{
    $action = ltrim($_SERVER['REQUEST_URI'], '/');
	if ($action == '')
		$action = $default;
    if (array_key_exists($action, $route))
    {
		if ((($route[$action] & 1) && isset($_SESSION['pseudo']))
        	|| (($route[$action] & 2) && !isset($_SESSION['pseudo']))
			|| (($route[$action] & 4) && $_SERVER['REQUEST_METHOD'] !== "GET")
			|| (($route[$action] & 8) && $_SERVER['REQUEST_METHOD'] !== "POST"))
        {
            $action = 'error';
			$options['error']['code'] = 401;
			$options['error']['message'] = 'Bad Request';
        }
    }
    else
    {
		$action = 'error';
		$options['error']['code'] = 404;
		$options['error']['message'] = 'Not Found';
	}
    require '../app/controller/' . $action . '.php';

    $action($container, $options);
}
catch (Exception $e)
{
    echo 'Erreur : ' . $e->getMessage();
}
