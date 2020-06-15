<?php

namespace Bauhaus\AssertPsrResponse;

use RuntimeException;

class PsrResponseAssertionException extends RuntimeException
{
    public function __construct(array $mismatchMessages)
    {
        $message = implode("\n", $mismatchMessages);

        parent::__construct($message);
    }
}
