<?php

namespace Fefas\AssertPsrResponse;

trait AssertExceptionTrait
{
    private function expectAssertPsrResponseExceptionWithMessage(string $message): void
    {
        $message = str_replace('/', '\/', $message);

        $this->expectException(AssertPsrResponseException::class);
        $this->expectExceptionMessageRegExp("/^$message$/");
    }
}
