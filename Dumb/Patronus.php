<?php

declare(strict_types=1);

namespace Dumb;

class Patronus
{
    public $code;

    protected $container;

    protected $request;

    protected $response = [];

    protected $method;

    public function __construct(array $container, string $method, int $code = 200)
    {
        $this->code = $code;
        $this->method = $method;
        $this->container = $container;
    }

    public function __call(string $string, array $args)
    {
        $this->code = 405;
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

    public function bomb(array $options)
    {
        echo json_encode($this->response);
    }
}
