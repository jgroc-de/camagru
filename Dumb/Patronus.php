<?php

declare(strict_types=1);

namespace Dumb;

use App\Library\Exception;

/**
 * this is the parent class for controller.
 */
abstract class Patronus
{
    /** @var int */
    public $code;

    /** @var array */
    protected $response = [];

    /** @var string */
    protected $method;

    public function __construct(string $method, int $code = 200)
    {
        $this->method = $method;
        $this->code = $code;
    }

    public function __call(string $string, array $args): void
    {
        throw new Exception("{$string} controller error", Response::METHOD_NOT_ALLOWED);
    }

    public function trap(Request $request): void
    {
        switch ($this->method) {
            case 'get':
                $this->get($request);

                break;
            case 'post':
                $this->post($request);

                break;
            case 'put':
                $this->put($request);

                break;
            case 'patch':
                $this->patch($request);

                break;
            case 'delete':
                $this->delete($request);

                break;
            default:
                $this->{$this->method}();
        }
        $response = Response::getInstance();
        $response->setStatusCode($this->code);
    }

    public function bomb(): string
    {
        return json_encode($this->response);
    }

    public function get(Request $request): void
    {
        throw new Exception('controller error', Response::METHOD_NOT_ALLOWED);
    }

    public function post(Request $request): void
    {
        throw new Exception('controller error', Response::METHOD_NOT_ALLOWED);
    }

    public function put(Request $request): void
    {
        throw new Exception('controller error', Response::METHOD_NOT_ALLOWED);
    }

    public function delete(Request $request): void
    {
        throw new Exception('controller error', Response::METHOD_NOT_ALLOWED);
    }

    public function patch(Request $request): void
    {
        throw new Exception('controller error', Response::METHOD_NOT_ALLOWED);
    }
}
