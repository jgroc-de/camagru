<?php

declare(strict_types=1);

namespace App\Controller;

use Dumb\Patronus;

class error extends Patronus
{
    public function __call(string $method, $args)
    {
    }

    public function bomb(array $response = null)
    {
        echo json_encode($response);
    }
}