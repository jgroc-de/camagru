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

    protected $uri;

    private $middlewares = array();

    private $forms = array();

    protected $args = array();

    public function __set(string $method, array $routes)
    {
        if ($this->found) {
            return;
        }
        if (false !== ($key = array_search($this->uri, $routes))) {
            $this->found = true;
            if (is_string($key)) {
                $this->uri = $key;
            }
            if ($_SERVER['REQUEST_METHOD'] !== $method) {
                $this->error(405);
            }
        }
    }

    public function add($function, array $routes)
    {
        if (empty($routes) || in_array($this->uri, $routes)) {
            $this->middlewares[] = $function;
        } elseif (isset($routes[$this->uri])) {
            $this->forms[] = [$function, $routes[$this->uri]];
        }
    }

    protected function error(int $httpCode)
    {
        $this->uri = '/error';
        $this->args['error']['code'] = $httpCode;
        $this->args['error']['message'] = self::HTTP_CODE[$httpCode];
    }

    protected function middleware()
    {
        if (!$this->found) {
            $this->error(404);

            return 0;
        }
        foreach ($this->middlewares as $middleware) {
            if (($error = $middleware()) >= 400) {
                $this->error($error);

                return 0;
            }
        }

        return 1;
    }

    protected function form()
    {
        foreach ($this->forms as $form) {
            $action = array_shift($form);
            $param = $form[0];
            foreach ($param as $key => $type) {
                if (($error = $action($key, $type)) >= 400) {
                    $this->error($error);

                    return 0;
                }
            }
        }

        return 1;
    }
}
