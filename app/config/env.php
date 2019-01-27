<?php

//$dbopts = parse_url(getenv('DATABASE_URL'));
$DB = array(
    /*'driver' => 'pgsql',
    'user' => $dbopts['user'],
    'host' => $dbopts['host'],
    'port' => $dbopts['port'],
    'password' => $dbopts['pass'],
    'name' => ltrim($dbopts['path'], '/'),*/
    'driver' => 'mysql',
    'user' => 'root',
    'password' => 'root00',
    'host' => 'localhost',
    'name' => 'camagru',
    'export' => __DIR__.'/../config/camagru.sql',
    'port' => '3306'
);
