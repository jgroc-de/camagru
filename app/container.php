<?php

use App\Model\CamagruManager;
use App\Model\CommentManager;
use App\Model\ConfigManager;
use App\Model\MailManager;
use App\Model\PicManager;
use App\Model\UserManager;
use Dumb\Dumb;

/**
 * equip.
 * equip everything u need into the container of dumb.
 *
 * @param Dumb $baka
 */
function equip(Dumb $baka)
{
    $baka->setContainer([
        'env' => function (): array {
            //$dbopts = parse_url(getenv('DATABASE_URL'));
            return [
                /*'driver' => 'pgsql',
                    'user' => $dbopts['user'],
                    'host' => $dbopts['host'],
                    'port' => $dbopts['port'],
                    'password' => $dbopts['pass'],
                    'name' => ltrim($dbopts['path'], '/'),*/
                'driver' => 'mysql',
                'user' => 'root',
                'password' => 'root@GG93',
                'host' => 'localhost',
                'name' => 'camagru',
                'export' => __DIR__.'/DB/camagru.sql',
                'port' => '3306',
            ];
        },
        'db' => function ($DB): PDO {
            $DB_DSN = $DB['driver'].':host='.$DB['host'].';dbname='.$DB['name'].';';

            return new \PDO($DB_DSN, $DB['user'], $DB['password'], [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            ]);
        },
        'camagru' => function ($c) {
            return new CamagruManager($c);
        },
        'comment' => function ($c) {
            return new CommentManager($c);
        },
        'config' => function ($c) {
            return new ConfigManager($c);
        },
        'picture' => function ($c) {
            return new PicManager($c);
        },
        'mail' => function () {
            return new MailManager();
        },
        'user' => function ($c) {
            return new UserManager($c);
        },
    ]);
}
