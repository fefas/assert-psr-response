<?php

namespace Fefas\AssertPsrResponse;

use RuntimeException;
use Psr\Http\Message\ResponseInterface as Response;
use Fefas\AssertPsrResponse\Assertions\Assertion;
use Fefas\AssertPsrResponse\Assertions\HeaderLineAssertion;
use Fefas\AssertPsrResponse\Assertions\JsonBodyAssertion;
use Fefas\AssertPsrResponse\Assertions\StatusCodeAssertion;

class AssertPsrResponse
{
    private $responseToAssert;
    private $assertions = [];

    public function __construct(Response $responseToAssert)
    {
        $this->responseToAssert = $responseToAssert;
    }

    public function assert(): bool
    {
        $failedMessage = [];
        foreach ($this->assertions as $assertion) {
            if ($assertion->isFailed()) {
                $failedMessage[] = $assertion->failedMessage();
            }
        }

        if (empty($failedMessage)) {
            return true;
        }

        throw new RuntimeException(implode("\n", $failedMessage));
    }

    public function addStatusCodeToAssert(int $expectedStatusCode): void
    {
        $statusCodeAssertion = new StatusCodeAssertion(
            $expectedStatusCode,
            $this->responseToAssert
        );

        $this->addAssertion($statusCodeAssertion);
    }

    public function addHeaderLineToAssert(
        string $headerName,
        string $expectedHeaderLine
    ): void {
        $headerLineAssertion = new HeaderLineAssertion(
            $expectedHeaderLine,
            $headerName,
            $this->responseToAssert
        );

        $this->addAssertion($headerLineAssertion);
    }

    public function addJsonBodyContentToAssert(string $expectedJsonBody): void
    {
        $jsonBodyAssertion = new JsonBodyAssertion(
            $expectedJsonBody,
            $this->responseToAssert
        );

        $this->addAssertion($jsonBodyAssertion);
    }

    private function addAssertion(Assertion $assertion): void
    {
        $this->assertions[] = $assertion;
    }
}
