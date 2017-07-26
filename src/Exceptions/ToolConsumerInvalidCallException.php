<?php

namespace RobertBoes\LaravelLti\Exceptions;

use Exception;
use Throwable;

class ToolConsumerInvalidCallException extends Exception
{
    public function __construct($message = "The call to the ToolConsumer was invalid (invalid property or method)", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}