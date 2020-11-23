<?php

declare(strict_types=1);

namespace Dumb;

use Psr\Http\Message\ResponseInterface;

/**
 * this is the "main" of the framework.
 */
class Dumb
{
    /** @var array $container */
    public $container;

    /** @var BakaDo $router */
    private $router;
    /** @var IronWall $middleware */
    private $middleware;
    /** @var KGB $formValidator */
    private $formValidator;
    /** @var $ghost */
    private $ghost;

    public function __construct($functions = [])
    {
        /*spl_autoload_register(function ($class) {
            $path = explode('\\', $class);
            $class = implode('/', $path);
            require $class.'.php';
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
        $this->ghost = new Shell();
    }

    public function setRoutes(array $routes)
    {
        $this->router = new BakaDo($routes);
    }

    public function setMiddlewares(string $class, array $routes)
    {
        if ($this->router->isMiddleWareMatch($routes)) {
            $this->middleware->add($class);
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

    public function kamehameha()
    {
        try {
            $response = $this->middleware->handle(new Request());
            if ($response->getStatusCode() >= 400) {
                $response = $this->error($response);
            } else {
                /** @var Patronus $controller */
                $controller = $this->router->getController($this->container);
                $this->formValidator->check();
                $this->ghost->check($this->container);
                $response = $this->run($controller);
            }
        } catch (\Exception $e) {
            $response = $this->error(new Response($e->getCode(), $e->getMessage()));
        }
        $response->send();
    }

    private function run(Patronus $letter): Response
    {
        $letter->trap();
        $response = new Response();
        $response->setMessage($letter->bomb());

        return $response;
    }

    private function error(ResponseInterface $response): ResponseInterface
    {
        if ($response->getStatusCode() > 600) {
            $response = $response->withStatus(404, 'pdo error: ' . $response->getReasonPhrase());
        }
        if (!isset(Response::HTTP_CODE[$response->getStatusCode()])) {
            $response = $response->withStatus(404);
        }
        $response->setMessage(json_encode(['flash' => $response->getReasonPhrase()]));

        return $response;
    }
}
