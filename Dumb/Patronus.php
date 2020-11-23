<?php

declare(strict_types=1);

namespace Dumb;

/**
 * this is the parent class for controller.
 */
abstract class Patronus
{
    public $code;

    protected $container;

    protected $request;

    protected $response = [];

    protected $method;

    public function __call(string $string, array $args)
    {
        throw new \Exception("{$string} controller error", Response::METHOD_NOT_ALLOWED);
    }

    public function trap()
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
    }

    public function bomb(): string
    {
        return json_encode($this->response);
    }
}
