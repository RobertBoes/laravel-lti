<?php

namespace RobertBoes\LaravelLti\Exceptions;

use Exception;
use Throwable;

class ToolConsumerNotSetException extends Exception
{
    public function __construct($message = "Consumer was not set, methods on the consumer cannot be executed", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
