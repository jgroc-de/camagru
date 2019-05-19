<?php

declare(strict_types=1);

namespace Dumb;

class Patronus
{
    public $code;

    protected $response = [];

    protected $method;

    public function __construct(string $method, int $code = 200)
    {
        $this->code = $code;
        $this->method = $method;
    }

    public function trap(array $c)
    {
    }

    public function bomb(array $options)
    {
        echo json_encode($this->response);
    }
}
