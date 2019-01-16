<?php

class ConfigManager extends SqlManager
{
	protected function dbconnect()
	{
		$db = $this->env;
		$db_dsn = $db['driver'] . ':host='. $db['host'] . ';port=' . $db['port'];

		return new PDO($db_dsn, $db['user'], $db['password'], array(
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
		));
	}
	
	public function	createDB($DBName)
	{
		$db = $this->dbconnect();
		$db->exec('DROP DATABASE IF EXISTS ' . $DBName);
		$db->exec('CREATE DATABASE ' . $DBName);
	}
	
	public function	request($file)
	{
		$this->db->exec($file);
	}
}
