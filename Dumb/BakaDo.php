<?php

declare(strict_types=1);

namespace Dumb;

use App\Library\Exception;

class BakaDo
{
    /** @var Patronus */
    private $controller;

    /** @var array */
    private $routes = [];

    /** @var string */
    private $method;

    /** @var string */
    private $uri;

    public function __construct(array $routes, Request $request)
    {
        $this->routes = $routes;
        $this->method = strtolower($_SERVER['REQUEST_METHOD']);
        $this->setUri($request);
    }

    public function getController(): Patronus
    {
        if (!$this->isSetRoute()) {
            $this->uri = 'home';
        }
        $this->setController();
        if (!method_exists($this->controller, $this->method)) {
            throw new Exception('method '.$this->method.' forbidden for this routes', Response::METHOD_NOT_ALLOWED);
        }

        return $this->controller;
    }

    public function isMiddleWareMatch(array $routes): bool
    {
        if (empty($routes)) {
            return true;
        }

        return $this->isMatch($routes);
    }

    public function isGhostMatch(array $routes): bool
    {
        return $this->isMatch($routes);
    }

    public function getFormParameters(array $routes): array
    {
        if (isset($routes[$this->uri][$this->method])) {
            return $routes[$this->uri][$this->method];
        }

        return [];
    }

    private function setController(): void
    {
        $class = '\App\Controller\\'.($this->uri);
        $this->controller = new $class($this->method);
    }

    private function setUri(Request $request): void
    {
        $uri = explode('/', $_SERVER['REQUEST_URI']);
        $this->uri = explode('?', $uri[1])[0];
        if (isset($uri[2])) {
            $request->setParams('id', (int) $uri[2]);
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

    private function isMatch(array $routes): bool
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
