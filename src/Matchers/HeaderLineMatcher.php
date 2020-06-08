<?php

namespace Bauhaus\AssertPsrResponse\Matchers;

use Psr\Http\Message\ResponseInterface as Response;

class HeaderLineMatcher extends ScalarEqualsMatcher
{
    public function __construct(string $expected, string $headerName, Response $responseToAssert)
    {
        $toAssert = $responseToAssert->getHeaderLine($headerName);
        $mismatchMessageTemplate =  [$headerName, $toAssert, $expected];

        parent::__construct($expected, $toAssert, $mismatchMessageTemplate);
    }

    protected function mismatchMessageTemplate(): string
    {
        return 'Failed matching response header line \'%s\' \'%s\' with the expected \'%s\'';
    }
}
