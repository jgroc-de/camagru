<?php

session_set_cookie_params(2520);
session_start();

//autoloader
//require __DIR__.'/../vendor/autoload.php';
//Dumb Framework
require 'Dumb/Dumb.php';

//Dumb Framework is alive!!!
$baka = new Dumb\Dumb();

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
