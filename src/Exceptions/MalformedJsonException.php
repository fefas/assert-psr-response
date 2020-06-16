<?php

namespace Bauhaus\AssertPsrResponse\Exceptions;

use InvalidArgumentException;
use Throwable;

class MalformedJsonException extends InvalidArgumentException
{
    public function __construct(string $malformedJson, Throwable $previousEx)
    {
        $message = "Malformed JSON provided:\n$malformedJson";
        $code = 0;

        parent::__construct($message, $code, $previousEx);
    }
}
