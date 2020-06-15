<?php

namespace Bauhaus\AssertPsrResponse;

use Bauhaus\AssertPsrResponse\Matchers\Matcher;
use Psr\Http\Message\ResponseInterface as PsrResponse;

class AlwaysNotMatching implements Matcher
{
    public function match(PsrResponse $psrResponse): bool
    {
        return false;
    }

    public function mismatchMessage(PsrResponse $psrResponse): string
    {
        return 'always not matching';
    }
}
