<?php

namespace App\Model;

class ConfigManager extends SqlManager
{
    public function createDB(string $DBName)
    {
        $db = $this->dbconnect();
        $db->exec('DROP DATABASE IF EXISTS '.$DBName);
        $db->exec('CREATE DATABASE '.$DBName);
    }

    public function request(string $file)
    {
        $this->container->db->exec($file);
    }

    protected function dbconnect()
    {
        $db = $this->container->env;
        $db_dsn = $db['driver'].':host='.$db['host'].';port='.$db['port'];

        return new \PDO($db_dsn, $db['user'], $db['password'], [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
        ]);
    }
}
