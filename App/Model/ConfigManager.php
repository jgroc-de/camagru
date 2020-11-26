<?php

namespace App\Model;

use Dumb\Dumb;
use PDO;

class ConfigManager
{
    /** @var PDO */
    protected $db;

    public function __construct()
    {
        if (!empty($_ENV['PROD'])) {
            $this->db = Dumb::getContainer()->get('db');
        } else {
            $db = Dumb::getContainer()->get('env');
            $db_dsn = $db['driver'].':host='.$db['host'].';port='.$db['port'];
            $this->db = new PDO($db_dsn, $db['user'], $db['password'], [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            ]);
        }
    }

    public function createDB(string $file): void
    {
        $test = $this->db->exec($file);
        echo $test;
    }
}
