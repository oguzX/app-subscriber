<?php

namespace App\Exception;

use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;

class RateLimitExceededException extends TooManyRequestsHttpException
{
    public function __construct(string $message = null, \Throwable $previous = null, int $code = null, array $headers = [])
    {
        parent::__construct($message, $previous, $code, $headers);
    }
}
