<?php

namespace Fefas\AssertPsrResponse\Assertions;

use Psr\Http\Message\ResponseInterface as Response;

class HeaderLineAssertion extends EqualsAssertion
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

    protected function failedMessageTemplate(): string
    {
        return 'Failed asserting response header line \'%s\' \'%s\' to the expected \'%s\'';
    }
}
