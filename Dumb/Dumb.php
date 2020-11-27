<?php

declare(strict_types=1);

namespace Dumb;

use Exception;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * this is the "main" of the framework.
 */
class Dumb
{
    /** @var ContainerInterface */
    private static $container;

    /** @var BakaDo */
    private $router;

    /** @var array */
    private $middlewareHandlers = [];

    /** @var KGB */
    private $formValidator;

    /** @var Request */
    private $request;

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
        $this->request = new Request();
    }

    public static function getContainer(): ContainerInterface
    {
        return self::$container;
    }

    public function setRouter(array $routes): void
    {
        $this->router = new BakaDo($routes, $this->request);
    }

    public function getRouter(): BakaDo
    {
        return $this->router;
    }

    public function setContainer(ContainerInterface $container): void
    {
        self::$container = $container;
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
        $controller = $this->router->getController();
        /** @var Response $response */
        $response = Response::getInstance($controller->code);
        $request = $this->request;

        try {
            $this->runMiddlewares($request);
            if ($response->getStatusCode() < 400) {
                $controller->trap($request);
                $response->setMessage($controller->bomb());
            } else {
                $response = $this->error($response);
            }
        } catch (Exception $exception) {
            $response->setAll((int) $exception->getCode(), $exception->getMessage());
        }

        $code = $response->getStatusCode();
        if (!isset(Response::HTTP_CODE[$code])) {
            $code = 500;
        }
        header('Cache-Control: max-age=3600');
        header($_SERVER['SERVER_PROTOCOL'].' '.$code.' '.Response::HTTP_CODE[$code]);
        /** @var Response $response */
        echo $response->getMessage();
    }

    private function runMiddlewares(Request $request): void
    {
        foreach ($this->middlewareHandlers as $middlewareHandler) {
            /** @var RequestHandlerInterface $middlewareHandler */
            $response = $middlewareHandler->handle($request);
            if ($response->getStatusCode() >= 400) {
                return;
            }
        }
        $this->formValidator->check();
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
