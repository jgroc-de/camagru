<?php

require '../app/config/env.php';

$api->container->env = function($c) {
    global $DB;
	return $DB;
};

$api->container->db = function($c) {
    $DB = $c->env;

    $DB_DSN = $DB['driver'] . ':host='. $DB['host'] . ';dbname=' . $DB['name'] .';';
    return new PDO($DB_DSN, $DB['user'], $DB['password'], array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ));  
};

$api->container->camagru = function ($c) {
    return new CamagruManager($c); 
};

$api->container->comment = function ($c) {
    return new CommentManager($c); 
};

$api->container->config = function ($c) {
    return new ConfigManager($c); 
};

$api->container->picture = function ($c) {
    return new PicManager($c); 
};

$api->container->mail = function ($c) {
    return new MailManager($c); 
};

$api->container->user = function ($c) {
    return new UserManager($c); 
};
