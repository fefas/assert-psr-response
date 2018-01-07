<?php

namespace Fefas\AssertPsrResponse\Assertions;

interface Assertion
{
    public function isFailed(): bool;
    public function failedMessage(): ?string;
}
