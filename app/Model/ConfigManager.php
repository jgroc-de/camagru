<?php

namespace App\Model;

class ConfigManager extends SqlManager
{
    public function createDB(string $DBName)
    {
        $this->dbconnect();
        $this->db->exec('DROP DATABASE IF EXISTS '.$DBName);
        $this->db->exec('CREATE DATABASE '.$DBName);
    }

    public function exec(string $file)
    {
        $this->db->exec($file);
    }

    protected function dbconnect()
    {
        $db = $this->container['env'];
        $db_dsn = $db['driver'].':host='.$db['host'].';port='.$db['port'];

        $this->db = new \PDO($db_dsn, $db['user'], $db['password'], [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
        ]);
    }
}
