<?php

declare(strict_types=1);

namespace App\Controller;

use Dumb\Patronus;

/**
 * home
 * provide home view.
 */
class home extends Patronus
{
    public function __construct(array $container, string $method, int $code = 200)
    {
        $this->container = $container;
        $this->method = $method;
        $this->code = $code;
    }

    public function get(): void
    {
    }

    public function bomb(): string
    {
        ob_start();
        require __DIR__.'/../../public/index.html';

        return ob_get_contents();
    }
}
