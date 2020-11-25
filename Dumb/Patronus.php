<?php

declare(strict_types=1);

namespace Dumb;

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
        throw new \Exception("{$string} controller error", Response::METHOD_NOT_ALLOWED);
    }

    public function trap(): void
    {
        switch ($this->method) {
            case 'get':
                $this->get();

                break;
            case 'post':
                $this->post();

                break;
            case 'put':
                $this->put();

                break;
            case 'patch':
                $this->patch();

                break;
            case 'delete':
                $this->delete();

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

    public function get(): void
    {
        throw new \Exception('controller error', Response::METHOD_NOT_ALLOWED);
    }

    public function post(): void
    {
        throw new \Exception('controller error', Response::METHOD_NOT_ALLOWED);
    }

    public function put(): void
    {
        throw new \Exception('controller error', Response::METHOD_NOT_ALLOWED);
    }

    public function delete(): void
    {
        throw new \Exception('controller error', Response::METHOD_NOT_ALLOWED);
    }

    public function patch(): void
    {
        throw new \Exception('controller error', Response::METHOD_NOT_ALLOWED);
    }
}
