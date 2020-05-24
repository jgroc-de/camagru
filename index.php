<?php

use Dumb\Dumb;
use Symfony\Component\Dotenv\Dotenv;

session_set_cookie_params(2520);
session_start();

//autoloader
require __DIR__.'/vendor/autoload.php';

//Dumb Framework load without autoloader
require 'Dumb/Dumb.php';

$dotenv = new Dotenv();
if (is_file(__DIR__.'/.env')) {
    $dotenv->load(__DIR__ . '/.env');
}

//Dumb Framework is alive!!!
$baka = new Dumb();

//set container
require 'App/container.php';
equip($baka);

//set routes
require 'App/Config/routes.php';
bakado($baka);

//set url validator
require 'App/Config/middlewares.php';
shield($baka);

//set form validator
require 'App/Config/forms.php';
trollBumper($baka);

//set specific validators
require 'App/Config/ghosts.php';
incept($baka);

$baka->kamehameha();
