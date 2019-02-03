<?php

declare(strict_types=1);

namespace Dumb;

class Patronus
{
    public $code;

    protected $response = [];

    public function __construct(int $code = 200)
    {
        $this->code = $code;
    }

    public function trap(array $c)
    {
    }

    public function bomb(array $options)
    {
        echo json_encode($this->response);
    }
}
