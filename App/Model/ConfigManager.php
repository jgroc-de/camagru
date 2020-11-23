<?php

namespace App\Model;

use PDO;

class ConfigManager
{
    /** @var PDO */
    protected $db;

    public function __construct(array $container = [])
    {
        $this->db = $container['env']();
    }

    public function createDB(string $file): void
    {
        $db_dsn = $this->db['driver'].':host='.$this->db['host'].';port='.$this->db['port'];
        $conn = new PDO($db_dsn, $this->db['user'], $this->db['password'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ]);
        $conn->exec($file);
    }
}
