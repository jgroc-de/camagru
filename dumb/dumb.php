<?php

require '../dumb/Dumbee.php';
require '../dumb/Bunkee.php';

class dumb extends Bunkee
{	
	public $container;

	public function __construct()
	{
		spl_autoload_register(function ($class) {
			require '../app/model/' . $class . '.php';
		});
		$this->uri = $_SERVER['REQUEST_URI'];
	}

	public function setContainer(array $functions)
	{
		$this->container = new Dumbee($functions);
	}

	public function dumb($args = null)
	{
		if ($this->middleware())
		{
			require '../app/controller' . $this->uri . '.php';
			$response = (ltrim($this->uri, '/'))($this->container, $args);
			if ($response)
			{
				header(self::ERROR_CODE[$response['code']]);
				unset($response['code']);
				echo json_encode($response);
			}
		}
		else
		{
			require '../app/controller/error.php';
			error($this->container, $this->args, $args);
		}
	}
}
