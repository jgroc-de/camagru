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

    private $found = false;

    private $middlewares = [];

    private $forms = [];

    private $ghosts = [];

    /**
     * __construct.
     *
     * @param mixed $functions
     */
    public function __construct($functions = [])
    {
        /*spl_autoload_register(function ($class) {
            require '../app/Model/'.$class.'.php';
        });*/
        $request = explode('/', $_SERVER['REQUEST_URI']);
        $this->uri = '/'.$request[1];
        if (isset($request[2]))
        {
            $_GET['id'] = $request[2];
        }
        $this->container = $functions;
    }

    /**
     * __set.
     *
     * @param string $method
     * @param array  $routes
     */
    public function __set(string $method, array $routes)
    {
        if ($this->found)
        {
            return;
        }
        if (false !== ($key = array_search($this->uri, $routes)))
        {
            $this->found = true;
            if (is_string($key))
            {
                $this->uri = $key;
            }
            if ($_SERVER['REQUEST_METHOD'] !== $method)
            {
                $this->error = 405;
            }
        }
    }

    public function setContainer(array $functions)
    {
        $this->container = array_merge($this->container, $functions);
    }

    /**
     * dumb.
     *
     * @param mixed $args
     */
    public function kamehameha($args = null)
    {
        if ($this->routes() || $this->middleware() || $this->form() || $this->ghost())
        {
            $letter = new \App\Controller\error($this->error);
        }
        else
        {
            $class = '\App\Controller\\'.strtolower($_SERVER['REQUEST_METHOD']).'\\'.(ltrim($this->uri, '/'));
            $letter = new $class();
        }
        $letter->trap($this->container);
		header("Cache-Control: max-age=360");
        header('HTTP/1.1 '.$letter->code.' '.self::HTTP_CODE[$letter->code]);
        if ($letter->code >= 400 && 'GET' === $_SERVER['REQUEST_METHOD'])
        {
            $letter = new \App\Controller\error($letter->code);
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
        if (empty($routes) || in_array($this->uri, $routes))
        {
            $this->middlewares[] = $function;
        }
        if (isset($routes[$this->uri]))
        {
            $this->forms[] = [$function, $routes[$this->uri]];
        }
    }

    public function eatF($function, array $routes)
    {
        if (isset($routes[$this->uri]))
        {
            $this->forms[] = [$function, $routes[$this->uri]];
        }
    }

    public function eatG($function, array $routes)
    {
        if (empty($routes) || in_array($this->uri, $routes))
        {
            $this->ghosts[] = $function;
        }
    }

    protected function routes()
    {
        if (!$this->found)
        {
            $this->error = 404;

            return 1;
        }

        return 0;
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
}
