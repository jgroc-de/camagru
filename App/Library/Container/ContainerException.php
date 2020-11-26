<?php

namespace App\Library\Container;

use Psr\Container\ContainerExceptionInterface;
use Throwable;

class ContainerException extends \Exception implements ContainerExceptionInterface
{
    /**
     * ContainerException constructor.
     *
     * @param string $message
     * @param int    $code
     */
    public function __construct($message = '', $code = 0, Throwable $previous = null)
    {
        parent::__construct("exception throw by service {$message}", $code, $previous);
    }
}
