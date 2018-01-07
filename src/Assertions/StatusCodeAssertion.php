<?php

namespace Fefas\AssertPsrResponse\Assertions;

use Psr\Http\Message\ResponseInterface as Response;

class StatusCodeAssertion implements Assertion
{
    private const FAILED_MESSAGE_TEMPLATE =
        'Failed asserting response status code \'%s\' to the expected \'%s\'';

    private $isFailed;
    private $failedMessage;

    public function __construct(int $expectedStatusCode, Response $responseToAssert)
    {
        $statusCodeToAssert = $responseToAssert->getStatusCode();
        $this->isFailed = $expectedStatusCode != $statusCodeToAssert;

        if ($this->isFailed()) {
            $this->failedMessage = $this->buildFailedMessage(
                $expectedStatusCode,
                $statusCodeToAssert
            );
        }
    }

    public function isFailed(): bool
    {
        return $this->isFailed;
    }

    public function failedMessage(): ?string
    {
        return $this->failedMessage;
    }

    private function buildFailedMessage(int $expected, int $asserted): ?string
    {
        return sprintf(self::FAILED_MESSAGE_TEMPLATE, $asserted, $expected);
    }
}
