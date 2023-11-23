<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class AuthenticationException extends Exception
{
    /**
     * AuthenticationException constructor.
     */
    public function __construct(string $message = '', int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
