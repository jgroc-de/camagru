<?php

namespace App\Library;

use Dumb\Dumb;
use Psr\Log\LoggerInterface;

class Exception extends \Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        /** @var LoggerInterface $log */
        $log = Dumb::getContainer()->get('log');
        $log->error($message);
    }
}
