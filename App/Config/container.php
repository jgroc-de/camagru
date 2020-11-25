<?php

use App\Model\CommentManager;
use App\Model\ConfigManager;
use App\Model\FilterManager;
use App\Model\LikesManager;
use App\Model\MailManager;
use App\Model\PicturesManager;
use App\Model\UserManager;
use Dumb\Dumb;

/**
 * equip everything u need into the container of dumb.
 */
$container = [
    'env' => function (): array {
        if (!empty($_ENV['DB_HOST'])) {
            return [
                'driver' => 'mysql',
                'user' => $_ENV['DB_USER'],
                'host' => $_ENV['DB_HOST'],
                'port' => $_ENV['DB_PORT'],
                'password' => $_ENV['DB_PASS'],
                'name' => $_ENV['DB_NAME'],
                'export' => '',
            ];
        }

        return [
            'driver' => 'mysql',
            'user' => 'camagru',
            'password' => 'camagru',
            'host' => 'localhost',
            'name' => 'camagru',
            'export' => __DIR__.'/../DB/camagru.sql',
            'port' => '3306',
        ];
    },
    'db' => function (): PDO {
        $DB = Dumb::getService('env');
        $DB_DSN = $DB['driver'].':host='.$DB['host'].';dbname='.$DB['name'].';port='.$DB['port'];
        //à remplacer par mysqli pour profiter des async pour les creations update delete

        return new \PDO($DB_DSN, $DB['user'], $DB['password'], [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
        ]);
    },
    'filter' => function () {
        return new FilterManager();
    },
    'comment' => function () {
        return new CommentManager();
    },
    'config' => function () {
        return new ConfigManager();
    },
    'picture' => function () {
        return new PicturesManager();
    },
    'like' => function () {
        return new LikesManager();
    },
    'mail' => function () {
        return new MailManager();
    },
    'user' => function () {
        return new UserManager();
    },
];
