<?php

use App\Model\CamagruManager;
use App\Model\CommentManager;
use App\Model\ConfigManager;
use App\Model\MailManager;
use App\Model\PicManager;
use App\Model\UserManager;

function armory($baka)
{
    $baka->setContainer([
        'env' => function (&$c) {
            //$dbopts = parse_url(getenv('DATABASE_URL'));
            $DB = [
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
                'port' => '3306',
            ];

            return $DB;
        },
        'db' => function (&$c) {
            $DB = $c->env;

            $DB_DSN = $DB['driver'].':host='.$DB['host'].';dbname='.$DB['name'].';';

            return new \PDO($DB_DSN, $DB['user'], $DB['password'], [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            ]);
        },
        'camagru' => function (&$c) {
            return new CamagruManager($c);
        },
        'comment' => function (&$c) {
            return new CommentManager($c);
        },
        'config' => function (&$c) {
            return new ConfigManager($c);
        },
        'picture' => function (&$c) {
            return new PicManager($c);
        },
        'mail' => function (&$c) {
            return new MailManager();
        },
        'user' => function (&$c) {
            return new UserManager($c);
        },
    ]);
}
