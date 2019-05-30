<?php

session_start();

//autoloader
require __DIR__.'/../vendor/autoload.php';
//Dumb Framework
require '../Dumb/Dumb.php';

//Dumb Framework is alive!!!
$baka = new Dumb\Dumb();

//require '../app/container.php';
//set container
equip($baka);

//require '../app/routes.php';
//set routes
bakado($baka);

//require '../app/middlewares.php';
//set url validator
shield($baka);

//require '../app/forms.php';
//set form validator
trollBumper($baka);

//require '../app/ghosts.php';
//set specific validators
incept($baka);

$baka->kamehameha();
