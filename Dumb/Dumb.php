<?php

declare(strict_types=1);

namespace Dumb;

class Dumb
{
    const HTTP_CODE = [
        200 => 'OK',
        401 => 'Bad Request',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        500 => 'Server Internal Error',
    ];

    public $container;

    protected $uri;

    protected $error = 0;

    private $controller;

    //routes available
    private $routes = [];

    //http verb
    private $method;

    private $middlewares = [];

    private $forms = [];

    private $ghosts = [];

    public function __construct($functions = [])
    {
        /*spl_autoload_register(function ($class) {
            require '../app/Model/'.$class.'.php';
        });*/
        $this->setUri();
        $this->method = strtolower($_SERVER['REQUEST_METHOD']);
        $_POST += (array)json_decode(file_get_contents('php://input'));
        $this->container = $functions;
    }

    public function bakado(array $routes)
    {
        $this->routes = $routes;
    }

    public function setContainer(array $functions)
    {
        $this->container = array_merge($this->container, $functions);
    }

    public function kamehameha($args = null)
    {
        if ($this->routes() || $this->middleware() || $this->form() || $this->ghost())
        {
            $this->controller = new \App\Controller\error($this->container, $this->method, $this->error);
        }
        $letter = $this->controller;
        try
        {
            $letter->trap();
        }
        catch (\Exception $e)
        {
            $letter->code = 500;
            var_dump($e);
        }
		header("Cache-Control: max-age=360");
        header('HTTP/1.1 '.$letter->code.' '.self::HTTP_CODE[$letter->code]);
        if ($letter->code >= 400 && 'GET' === $_SERVER['REQUEST_METHOD'])
        {
            $letter = new \App\Controller\error($this->method, $letter->code);
        }
        $letter->bomb($args);
    }

    /**
     * eat.
     *
     * @param mixed $function
     * @param array $routes
     */
    public function eatM($function, array $routes)
    {
        //if routes is empty, we apply the function for all routes
        if (
            empty($routes)
            || (
                array_key_exists($this->uri, $routes)
                && (
                    in_array($this->method, $routes[$this->uri])
                    || $routes[$this->uri] === []
                )
            )
        ) {
            $this->middlewares[] = $function;
        }
    }

    public function eatF($function, array $routes)
    {
        if (isset($routes[$this->uri][$this->method]))
        {
            $this->forms[] = [
                $function,
                $routes[$this->uri][$this->method]
            ];
        }
    }

    public function eatG($function, array $routes)
    {
        if (isset($routes[$this->uri])
            && in_array($this->method, $routes[$this->uri])
        ) {
            $this->ghosts[] = $function;
        }
    }

    protected function routes()
    {
        if (false !== ($key = array_search($this->uri, $this->routes)))
        {
            if (!is_int($key))
            {
                $this->uri = $key;
            }
            $class = '\App\Controller\\'.(ltrim($this->uri, '/'));
            $this->controller = new $class($this->container, $this->method);
            if (method_exists($this->controller, $this->method))
            {
                return 0;
            }
            $this->error = 405;
        }
        else
        {
            $this->error = 404;
        }

        return 1;
    }

    /**
     * middleware.
     */
    protected function middleware()
    {
        foreach ($this->middlewares as $middleware)
        {
            if (($error = $middleware()) >= 400)
            {
                $this->error = $error;

                return 1;
            }
        }

        return 0;
    }

    /**
     * form.
     */
    protected function form()
    {
        foreach ($this->forms as $form)
        {
            $action = array_shift($form);
            $param = $form[0];
            foreach ($param as $key => $type)
            {
                if (($error = $action($key, $type)) >= 400)
                {
                    $this->error = $error;

                    return 1;
                }
            }
        }

        return 0;
    }

    /**
     * ghost.
     */
    protected function ghost()
    {
        foreach ($this->ghosts as $ghost)
        {
            if (($error = $ghost($this->container)) >= 400)
            {
                $this->error = $error;

                return 1;
            }
        }

        return 0;
    }

    private function setUri()
    {
        $uri = explode('/', $_SERVER['REQUEST_URI']);
        $this->uri = '/'.$uri[1];
        if (isset($uri[2]))
        {
            $_GET['id'] = $uri[2];
        }
    }
}
