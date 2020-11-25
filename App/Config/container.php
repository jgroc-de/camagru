<?php

use App\Model\CommentManager;
use App\Model\ConfigManager;
use App\Model\FilterManager;
use App\Model\LikesManager;
use App\Model\MailManager;
use App\Model\PicturesManager;
use App\Model\UserManager;

/**
 * equip everything u need into the container of dumb.
 */
$container = [
    'env' => function (array $c): array {
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
    'db' => function (array $c): PDO {
        $DB = $c['env'];
        $DB_DSN = $DB['driver'].':host='.$DB['host'].';dbname='.$DB['name'].';port='.$DB['port'];
        //à remplacer par mysqli pour profiter des async pour les creations update delete

        return new \PDO($DB_DSN, $DB['user'], $DB['password'], [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
        ]);
    },
    'filter' => function (array $c) {
        return new FilterManager();
    },
    'comment' => function (array $c) {
        return new CommentManager();
    },
    'config' => function (array $c) {
        return new ConfigManager();
    },
    'picture' => function (array $c) {
        return new PicturesManager();
    },
    'like' => function (array $c) {
        return new LikesManager();
    },
    'mail' => function (array $c) {
        return new MailManager();
    },
    'user' => function (array $c) {
        return new UserManager();
    },
];
