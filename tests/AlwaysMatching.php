<?php

namespace Bauhaus\AssertPsrResponse;

use Bauhaus\AssertPsrResponse\Matchers\Matcher;
use Psr\Http\Message\ResponseInterface as PsrResponse;

class AlwaysMatching implements Matcher
{
    public function match(PsrResponse $psrResponse): bool
    {
        return true;
    }

    public function mismatchMessage(PsrResponse $psrResponse): string
    {
        return 'always matching';
    }
}
