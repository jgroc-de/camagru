<?php

declare(strict_types=1);

namespace Dumb;

class Dumb
{
    const HTTP_CODE = [
        200 => 'OK',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        500 => 'Server Internal Error',
        2002 => 'DB error',
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
        if ($input = file_get_contents('php://input')) {
            $_POST += (array) \json_decode($input);
        }
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
        try {
            $this->routes();
            $this->middleware();
            $this->form();
            $this->ghost();
            $letter = $this->controller;
            $letter->trap();
            header('Cache-Control: max-age=360');
            header('HTTP/1.1 '.$letter->code.' '.self::HTTP_CODE[$letter->code]);
            if ($args) {
                $letter->bomb($args);
            } else {
                $letter->bomb();
            }
        } catch (\Exception $e) {
            $this->controller = new \App\Controller\error($this->container, $this->method, $e->getCode());
            $letter = $this->controller;
            header('HTTP/1.1 '.$letter->code.' '.self::HTTP_CODE[$letter->code]);
            echo $e->getMessage();
        }
    }

    /**
     * eat.
     *
     * @param mixed $function
     * @param array $routes
     */
    public function setMiddlewares($function, array $routes)
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

    public function setFormValidator($function, array $routes)
    {
        if (isset($routes[$this->uri][$this->method])) {
            $this->forms[] = [
                $function,
                $routes[$this->uri][$this->method],
            ];
        }
    }

    public function setGhostShield($function, array $routes)
    {
        if (isset($routes[$this->uri])
            && in_array($this->method, $routes[$this->uri])
        ) {
            $this->ghosts[] = $function;
        }
    }

    public function isSetRoute(): bool
    {
        foreach ($this->routes as $key => $route) {
            if (is_array($route)) {
                if (in_array($this->uri, $route)) {
                    $this->uri = $key;

                    return true;
                }
            } elseif ($this->uri === $route) {
                return true;
            }
        }

        return false;
    }

    protected function routes()
    {
        if ($this->isSetRoute()) {
            $class = '\App\Controller\\'.($this->uri);
            $this->controller = new $class($this->container, $this->method);
            if (method_exists($this->controller, $this->method)) {
                return;
            }

            throw new \Exception('routes', 405);
        }

        throw new \Exception('routes', 404);
    }

    /**
     * middleware.
     */
    protected function middleware()
    {
        foreach ($this->middlewares as $middleware) {
            $error = $middleware();
        }
    }

    /**
     * form.
     */
    protected function form()
    {
        foreach ($this->forms as $form) {
            $action = array_shift($form);
            $param = $form[0];
            foreach ($param as $key => $type) {
                $error = $action($key, $type);
            }
        }
    }

    /**
     * ghost.
     */
    protected function ghost()
    {
        foreach ($this->ghosts as $ghost) {
            $error = $ghost($this->container);
        }
    }

    private function setUri()
    {
        $uri = explode('/', $_SERVER['REQUEST_URI']);
        $this->uri = $uri[1];
        if (isset($uri[2])) {
            $_GET['id'] = $uri[2];
        }
    }
}
