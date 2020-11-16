<?php

declare(strict_types=1);

namespace Dumb;

class BakaDo
{
    private $controller;

    //routes available
    private $routes = [];

    //http verb
    private $method;

    private $uri;

    public function __construct(array $routes)
    {
        $this->routes = $routes;
        $this->method = strtolower($_SERVER['REQUEST_METHOD']);
        $this->setUri();
    }

    public function getController($container): Patronus
    {
        if (!$this->isSetRoute()) {
            $this->uri = 'home';
        }
        $this->setController($container);
        if (!method_exists($this->controller, $this->method)) {
            throw new \Exception('method '.$this->method.' forbidden for this routes', Response::METHOD_NOT_ALLOWED);
        }

        return $this->controller;
    }

    public function isMiddleWareMatch($routes): bool
    {
        return true;
        if (empty($routes)) {
            return true;
        }

        return $this->isMatch($routes);
    }

    public function isGhostMatch($routes): bool
    {
        return $this->isMatch($routes);
    }

    public function getFormParameters($routes): array
    {
        if (isset($routes[$this->uri][$this->method])) {
            return $routes[$this->uri][$this->method];
        }

        return [];
    }

    private function setController($container)
    {
        $class = '\App\Controller\\'.($this->uri);
        $this->controller = new $class($container, $this->method);
    }

    private function setUri()
    {
        $uri = explode('/', $_SERVER['REQUEST_URI']);
        $this->uri = explode('?', $uri[1])[0];
        if (isset($uri[2])) {
            $_GET['id'] = (int) $uri[2];
        }
    }

    private function isSetRoute(): bool
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

    private function isMatch($routes): bool
    {
        if (isset($routes[$this->uri])) {
            $route = $routes[$this->uri];
            if (empty($route) || in_array($this->method, $route)) {
                return true;
            }
        }

        return false;
    }
}
