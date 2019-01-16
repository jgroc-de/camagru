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
 *  option 4: require function flash message
 */
$route = array(
    'listPics' => 0,
    'listPicsByLike' => 0,
    'picture' => 0,
    'signup' => 5,
    'validation' => 5,
    'login' => 5,
    'reinit' => 5,
    'logout' => 2,
    'settings' => 6,
    'camagru' => 0,
    'addComment' => 2,
    'addLike' => 2,
    'changeTitle' => 2,
    'createPic' => 2,
    'deletePic' => 2,
    'setup' => 0,
    'st_camagru' => 0
);
$default = 'listPics';
/**
 * initialisation de variable pour app/view/template.php
 */
$options = array(
    'last' => '',
    'trend' => '',
    'camagru' => '',
    'settings' => '',
    'login' => '',
    'signup' => '',
    'title2' => '',
    'script' => ''
);

try
{
    $action = isset($_GET['action']) ? $_GET['action'] : $default;
    if (array_key_exists($action, $route))
    {
        if (($route[$action] & 4))
        {
            require '../app/lib/flashMessage.php';
        }
        if (($route[$action] & 2) && !isset($_SESSION['pseudo']))
        {
            $action = $default;
        }
        elseif (($route[$action] & 1) && isset($_SESSION['pseudo']))
        {
            $action = $default;
        }
    }
    else
    {
        $action = $default;
    }
    require '../app/controller/' . $action . '.php';
    $action($container, $options);
}
catch (Exception $e)
{
    echo 'Erreur : ' . $e->getMessage();
}
