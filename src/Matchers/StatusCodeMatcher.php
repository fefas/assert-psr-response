<?php

namespace Fefas\AssertPsrResponse\Matchers;

use Psr\Http\Message\ResponseInterface as Response;

class StatusCodeMatcher extends ScalarEqualsMatcher
{
    public function __construct(int $expectedStatusCode, Response $responseToAssert)
    {
        $statusCodeToAssert = $responseToAssert->getStatusCode();
        $mismatchMessageParams = [
            $statusCodeToAssert,
            $expectedStatusCode,
        ];

        parent::__construct($expectedStatusCode, $statusCodeToAssert, $mismatchMessageParams);
    }

    protected function mismatchMessageTemplate(): string
    {
        return 'Failed matching response status code \'%s\' with the expected \'%s\'';
    }
}
