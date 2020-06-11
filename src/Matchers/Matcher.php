<?php

namespace Bauhaus\AssertPsrResponse\Matchers;

use Psr\Http\Message\ResponseInterface as PsrResponse;

interface Matcher
{
    public function match(PsrResponse $psrResponse): bool;
    public function mismatchMessage(PsrResponse $psrResponse): string;
}
