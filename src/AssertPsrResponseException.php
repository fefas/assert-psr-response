<?php

namespace Bauhaus\AssertPsrResponse;

use RuntimeException;

class AssertPsrResponseException extends RuntimeException
{
    public function __construct(array $mismatchMessages)
    {
        $message = implode("\n", $mismatchMessages);

        parent::__construct($message);
    }
}
