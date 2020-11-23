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
            'export' => __DIR__.'/DB/camagru.sql',
            'port' => '3306',
        ];
    },
    'db' => function ($DB): PDO {
        $DB_DSN = $DB['driver'].':host='.$DB['host'].';dbname='.$DB['name'].';port='.$DB['port'];
        //à remplacer par mysqli pour profiter des async pour les creations update delete

        return new \PDO($DB_DSN, $DB['user'], $DB['password'], [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
        ]);
    },
    'filter' => function ($c) {
        return new FilterManager($c);
    },
    'comment' => function ($c) {
        return new CommentManager($c);
    },
    'config' => function ($c) {
        return new ConfigManager($c);
    },
    'picture' => function ($c) {
        return new PicturesManager($c);
    },
    'like' => function ($c) {
        return new LikesManager($c);
    },
    'mail' => function () {
        return new MailManager();
    },
    'user' => function ($c) {
        return new UserManager($c);
    },
];
