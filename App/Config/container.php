<?php

use App\Library\Container\Container;
use App\Library\Mail\PHPMailer2;
use App\Library\MailSender;
use App\Model\CommentManager;
use App\Model\ConfigManager;
use App\Model\FilterManager;
use App\Model\LikesManager;
use App\Model\PicturesManager;
use App\Model\UserManager;
use Dumb\Dumb;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

/**
 * equip everything u need into the container of dumb.
 */
$container = new Container();

$log = new Logger('camagru');
$log->pushHandler(new StreamHandler('php://stderr', Logger::WARNING));

$container->setAll([
    'env' => function (): array {
        if (!empty($_ENV['PROD'])) {
            return [
                'driver' => 'mysql',
                'user' => $_ENV['DB_USER'],
                'host' => $_ENV['DB_HOST'],
                'port' => $_ENV['DB_PORT'],
                'password' => $_ENV['DB_PASS'],
                'name' => $_ENV['DB_NAME'],
                'export' => __DIR__.'/../DB/camagru.sql',
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
        $DB = Dumb::getContainer()->get('env');
        $DB_DSN = $DB['driver'].':host='.$DB['host'].';dbname='.$DB['name'].';port='.$DB['port'];
        //à remplacer par mysqli pour profiter des async pour les creations update delete

        return new PDO($DB_DSN, $DB['user'], $DB['password'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
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
    'user' => function () {
        return new UserManager();
    },
    'mail' => function () {
        if (!empty($_ENV['PROD'])) {
            if (isset($_ENV['MAILGUN_API_KEY'])) {
                $mail = new \App\Library\Mail\MailGun();
            } else {
                $mail = new \App\Library\Mail\SendGrid();
            }
        } else {
            $mail = new PHPMailer2();
        }
        $proto = 0 === strpos($_SERVER['HTTP_HOST'], 'localhost') ? 'http' : 'https';

        return new MailSender(null, $mail, $proto.'://'.$_SERVER['HTTP_HOST']);
    },
    'log' => $log,
]);
