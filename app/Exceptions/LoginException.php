<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class LoginException extends Exception
{
    /**
     * LoginException constructor.
     */
    public function __construct(string $message = '', int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
