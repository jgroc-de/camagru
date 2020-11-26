<?php

namespace App\Library\Container;

use Exception;
use Psr\Container\NotFoundExceptionInterface;
use Throwable;

class NotFoundException extends Exception implements NotFoundExceptionInterface
{
    /**
     * NotFoundException constructor.
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     * @return void
     */
    public function __construct($message = '', $code = 0, Throwable $previous = null)
    {
        parent::__construct("{$message} not found in container", $code, $previous);
    }
}
