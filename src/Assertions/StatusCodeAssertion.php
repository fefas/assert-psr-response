<?php

namespace Fefas\AssertPsrResponse\Assertions;

use Psr\Http\Message\ResponseInterface as Response;

class StatusCodeAssertion extends EqualsAssertion
{
    public function __construct(int $expectedStatusCode, Response $responseToAssert)
    {
        $statusCodeToAssert = $responseToAssert->getStatusCode();

        parent::__construct($expectedStatusCode, $statusCodeToAssert, [
            $statusCodeToAssert,
            $expectedStatusCode,
        ]);
    }

    protected function failedMessageTemplate(): string
    {
        return 'Failed asserting response status code \'%s\' to the expected \'%s\'';
    }
}
