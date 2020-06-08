<?php

namespace Bauhaus\AssertPsrResponse\Matchers;

use Psr\Http\Message\ResponseInterface as Response;

class StatusCodeMatcher extends ScalarEqualsMatcher
{
    public function __construct(int $expected, Response $responseToAssert)
    {
        $toAssert = $responseToAssert->getStatusCode();
        $mismatchMessageParams = [$toAssert, $expected];

        parent::__construct($expected, $toAssert, $mismatchMessageParams);
    }

    protected function mismatchMessageTemplate(): string
    {
        return 'Failed matching response status code \'%s\' with the expected \'%s\'';
    }
}
