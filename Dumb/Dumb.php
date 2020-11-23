<?php

declare(strict_types=1);

namespace Dumb;

use Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * this is the "main" of the framework.
 */
class Dumb
{
    /** @var array */
    public $container;

    /** @var BakaDo */
    private $router;

    /** @var array */
    private $middlewareHandlers = [];

    /** @var KGB */
    private $formValidator;

    public function __construct()
    {
        /*spl_autoload_register(function ($class) {
            $path = explode('\\', $class);
            $class = implode('/', $path);
            require $class.'.php';
        });*/
        if ($input = file_get_contents('php://input')) {
            $_POST += (array) json_decode($input);
        }
        $this->formValidator = new KGB();
    }

    public function setRouter(BakaDo $router): void
    {
        $this->router = $router;
    }

    public function setContainer(array $container): void
    {
        $this->container = $container;
    }

    public function addMiddlewareHandlers(IronWall $middlewareHandler): void
    {
        $this->middlewareHandlers[] = $middlewareHandler;
    }

    public function setFormValidator(object $function, array $routes): void
    {
        $formParams = $this->router->getFormParameters($routes);
        $this->formValidator->add($function, $formParams);
    }

    public function kamehameha(): void
    {
        try {
            $controller = $this->router->getController($this->container);
            /** @var Response $response */
            $response = $this->runMiddlewares();
            if ($response->getStatusCode() < 400) {
                $controller->trap();
                $response->setMessage($controller->bomb());
            } else {
                $response = $this->error($response);
            }
        } catch (Exception $exception) {
            /** @var Response $response */
            $response = new Response($exception->getCode(), $exception->getMessage());
        }

        $code = $response->getStatusCode();
        header('Cache-Control: max-age=3600');
        header($_SERVER['SERVER_PROTOCOL'] ?? ''.' '.$code.' '.Response::HTTP_CODE[$code]);
        echo $response->getMessage();
    }

    private function runMiddlewares(): ResponseInterface
    {
        $request = new Request();
        $response = new Response();
        foreach ($this->middlewareHandlers as $middlewareHandler) {
            /** @var RequestHandlerInterface $middlewareHandler */
            $response = $middlewareHandler->handle($request);
            if ($response->getStatusCode() >= 400) {
                return $response;
            }
        }
        $this->formValidator->check();

        return $response;
    }

    private function error(ResponseInterface $response): ResponseInterface
    {
        /** @var Response $response */
        if ($response->getStatusCode() > 600) {
            $response = $response->withStatus(404, 'pdo error: '.$response->getReasonPhrase());
        }
        if (!isset(Response::HTTP_CODE[$response->getStatusCode()])) {
            $response = $response->withStatus(404);
        }
        $response->setMessage(json_encode(['flash' => $response->getReasonPhrase()]));

        return $response;
    }
}
