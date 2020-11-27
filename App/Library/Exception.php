<?php

namespace App\Library;

use Dumb\Dumb;
use Psr\Log\LoggerInterface;
use Throwable;

class Exception extends \Exception
{
    /**
     * Exception constructor.
     *
     * @param string $message
     * @param int    $code
     */
    public function __construct($message = '', $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        /** @var LoggerInterface $log */
        $log = Dumb::getContainer()->get('log');
        $log->error($message);
    }
}
