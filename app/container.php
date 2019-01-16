<?php

/**
 * @class Twittee
 *
 * @author: fabien Potencier
 */
class Twittee
{
    protected $container = array();

    public function __set($key, $value)
    {
        $this->container[$key] = $value;
    }

    public function __get($key)
    {
        return $this->container[$key]($this);
    }
}

$container = new Twittee();

$container->env = function($c) {
    global $DB;

	return $DB;
};

$container->db = function($c) {
    global $DB;

    $DB_DSN = $DB['driver'] . ':host='. $DB['host'] . ';dbname=' . $DB['name'] .';';
    return new PDO($DB_DSN, $DB['user'], $DB['password'], array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ));  
};

$container->camagru = function ($c) {
    return new CamagruManager($c); 
};

$container->comment = function ($c) {
    return new CommentManager($c); 
};

$container->config = function ($c) {
    return new ConfigManager($c); 
};

$container->picture = function ($c) {
    return new PicManager($c); 
};

$container->mail = function ($c) {
    return new MailManager($c); 
};

$container->user = function ($c) {
    return new UserManager($c); 
};

