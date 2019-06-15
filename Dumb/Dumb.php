<?php

declare(strict_types=1);

namespace Dumb;

/**
 * this is the "main" of the framework
 */
class Dumb
{
    public $container;

	private $router;
	private $middleware;
    private $formValidator;
    private $ghost;

    public function __construct($functions = [])
    {
        /*spl_autoload_register(function ($class) {
            require '../app/Model/'.$class.'.php';
        });*/
        if ($input = file_get_contents('php://input')) {
            $_POST += (array) \json_decode($input);
        }
        $this->container = $functions;
		$this->middleware = new IronWall();
		$this->formValidator = new KGB();
    }

    public function setContainer(array $functions)
    {
        $this->container = array_merge($this->container, $functions);
		//side effect…
		$this->ghost = new Shell($this->container);
    }

	public function setRoutes(array $routes)
	{
		$this->router = new Bakado($routes);
	}

	public function setMiddlewares($function, array $routes)
	{
		if ($this->router->isMiddleWareMatch($routes)) {
			$this->middleware->add($function);
		}
	}

    public function setFormValidator($function, array $routes)
    {
		$formParams = $this->router->getFormParameters($routes);
		$this->formValidator->add($function, $formParams);
	}

    public function setGhostShield($function, array $routes)
    {
		if ($this->router->isGhostMatch($routes)) {
            $this->ghost->add($function);
		}
    }

    public function kamehameha($args = null)
    {
        try {
            $controller = $this->router->getController($this->container);
            $this->middleware->check();
            $this->formValidator->check();
            $this->ghost->check($this->container);
			$this->run($controller, $args);
        } catch (\Exception $e) {
			$this->error($e);
        }
    }

	private function run($letter, $args)
	{
		$letter->trap();
		header('Cache-Control: max-age=360');
		header('HTTP/1.1 '.$letter->code.' '. Response::HTTP_CODE[$letter->code]);
		$letter->bomb($args);
	}

	private function error($e)
	{
		$this->controller = new \App\Controller\error($this->container, 'get', (int) $e->getCode());
		$letter = $this->controller;
		header('HTTP/1.1 '.$letter->code.' '.Response::HTTP_CODE[$letter->code]);
		$letter->bomb(['flash' => $e->getMessage()]);
	}
}
