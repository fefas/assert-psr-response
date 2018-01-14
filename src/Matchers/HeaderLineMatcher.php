<?php

namespace Fefas\AssertPsrResponse\Matchers;

use Psr\Http\Message\ResponseInterface as Response;

class HeaderLineMatcher extends ScalarEqualsMatcher
{
    public function __construct(
        string $expectedHeaderLine,
        string $headerName,
        Response $responseToAssert
    ) {
        $headerLineToAssert = $responseToAssert->getHeaderLine($headerName);

        parent::__construct($expectedHeaderLine, $headerLineToAssert, [
            $headerName,
            $headerLineToAssert,
            $expectedHeaderLine,
        ]);
    }

    protected function mismatchMessageTemplate(): string
    {
        return 'Failed matching response header line \'%s\' \'%s\' with the expected \'%s\'';
    }
}
