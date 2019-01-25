<?php

class Bunkee
{
	const HTTP_CODE = [
		200 => 'OK',
		401 => 'Bad Request',
		403 => 'Forbidden',
		404 => 'Not Found',
		405 => 'Method Not Allowed',
		500 => 'Server Internal Error',
	];

	private $found = false;

	private $route = array();

	protected $uri;

	private $middlewares = array();

	private $i = 0;

	protected $args = array();

	public function __set(string $method, array $routes)
	{
		if ($this->found)
			return ;
		if (($key = array_search($this->uri, $routes)) !== false)
		{
			$this->found = true;
			if (is_string($key))
				$this->uri = $key;
			if ($_SERVER['REQUEST_METHOD'] !== $method)
			{
				$this->error(405);
			}
		}
	}

	public function add($function, array $routes)
	{
		$this->middlewares[] = $function;
		if (empty($routes))
		{
			$this->route[] = $this->i;
		}
		else if (in_array($this->uri, $routes))
		{
			$this->route[] = $this->i;
		}
		$this->i++;
	}

	protected function error(int $httpCode)
	{
		$this->uri = '/error';
		$this->args['error']['code'] = $httpCode;
		$this->args['error']['message'] = self::HTTP_CODE[$httpCode];
	}

	protected function middleware()
	{
		if (!$this->found)
		{
			$this->error(404);
			return 0;
		}
		foreach ($this->route as $middleware)
		{
			$action = $this->middlewares[$middleware];
			if (($error = $action()) >= 400)
			{
				$this->error($error);
				return 0;
			}
		}
		return 1;
	}
}
