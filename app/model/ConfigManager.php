<?php

class ConfigManager extends SqlManager
{
    /**
     * createDB.
     *
     * @param string $DBName
     */
    public function createDB(string $DBName)
    {
        $db = $this->dbconnect();
        $db->exec('DROP DATABASE IF EXISTS '.$DBName);
        $db->exec('CREATE DATABASE '.$DBName);
    }

    /**
     * request.
     *
     * @param string $file
     */
    public function request(string $file)
    {
        $this->db->exec($file);
    }

    /**
     * dbconnect.
     *
     * @return PDO
     */
    protected function dbconnect()
    {
        $db = $this->env;
        $db_dsn = $db['driver'].':host='.$db['host'].';port='.$db['port'];

        return new PDO($db_dsn, $db['user'], $db['password'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ]);
    }
}
