<?php

require '../dumb/twittee.php';

class dumb
{
	/**
	 *  option 3: must be logout
	 *  option 4: must be login
	 */
	private $route = array();

	private $middlewares = array();

	private $uri;
	
	private $found = false;

	public $container;

	public function __construct()
	{
		spl_autoload_register(function ($class) {
			require '../app/model/' . $class . '.php';
		});
		$this->uri = $_SERVER['REQUEST_URI'];
		if ($this->uri == '/')
			$this->uri = '/listPics';
		 $this->container = new Twittee();
	}

    public function __set(string $method, array $routes)
	{
		if ($this->found)
			return ;
		foreach ($routes as $route)
		{
			if ($route === $this->uri)
			{
				$this->found = true;
				if ($_SERVER['REQUEST_METHOD'] !== $method)
				{
					$this->uri = '/error';
					$this->args['error']['code'] = 405;
					$this->args['error']['message'] = 'Method Not Allowed';
				}
				return ;
			}
		}
	}

	private function middleware()
	{
		foreach ($this->route as $middleware)
		{
			$action = $this->middlewares[$middleware];
			if (!$this->$action())
			{
				$this->uri = '/error';
				$this->args['error']['code'] = 401;
				$this->args['error']['message'] = 'Bad Request';
				break ;
			}
		}
	}

	public function dumb($args = array())
	{
		if (!$this->found)
		{
			$this->uri = '/error';
			$this->args['error']['code'] = 404;
			$this->args['error']['message'] = 'Not Found';
		}
		$this->middleware();
		require '../app/controller' . $this->uri . '.php';
		(ltrim($this->uri, '/'))($this->container, $args);
	}
}
