<?php

declare(strict_types=1);

namespace Dumb;

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

    protected $uri;

    protected $error = 0;

    private $found = false;

    private $middlewares = [];

    private $forms = [];

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

    /**
     * eat.
     *
     * @param mixed $function
     * @param array $routes
     */
    public function eat($function, array $routes)
    {
        if (empty($routes) || in_array($this->uri, $routes))
        {
            $this->middlewares[] = $function;
        }
        elseif (isset($routes[$this->uri]))
        {
            $this->forms[] = [$function, $routes[$this->uri]];
        }
    }

    /**
     * middleware.
     */
    protected function middleware()
    {
        if (!$this->found)
        {
            $this->error = 404;

            return;
        }
        foreach ($this->middlewares as $middleware)
        {
            if (($error = $middleware()) >= 400)
            {
                $this->error = $error;

                break;
            }
        }
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

                    break;
                }
            }
        }
    }
}
