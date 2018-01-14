<?php

namespace Fefas\AssertPsrResponse\Matchers;

interface Matcher
{
    public function match(): bool;
    public function mismatchMessage(): ?string;
}
