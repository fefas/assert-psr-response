<?php

namespace Fefas\AssertPsrResponse;

use RuntimeException;
use Psr\Http\Message\ResponseInterface;

class AssertPsrResponse
{
    private $responseToAssert;
    private $failedAssertingMessages = [];

    public function __construct(ResponseInterface $responseToAssert)
    {
        $this->responseToAssert = $responseToAssert;
    }

    public function assert(): bool
    {
        if (false === $this->hasAssertFailingMessages()) {
            return true;
        }

        throw new RuntimeException($this->assertFailingMessage());
    }

    public function statusCodeToAssert(int $expected): void
    {
        $current = $this->responseToAssert->getStatusCode();

        if ($expected != $current) {
            $this->appendAssertFailingMessage('status code', $expected, $current);
        }
    }

    public function headerLineToAssert(string $name, string $expected): void
    {
        $current = $this->responseToAssert->getHeaderLine($name);

        if ($expected !== $current) {
            $this->appendAssertFailingMessage("header line '$name'", $expected, $current);
        }
    }

    private function appendAssertFailingMessage(
        string $context,
        string $expected,
        string $current
    ): void {
        $this->failedAssertingMessages[] = <<<MSG
Failed asserting response $context '$current' to the expected '$expected'
MSG;
    }

    private function hasAssertFailingMessages(): bool
    {
        return count($this->failedAssertingMessages) > 0;
    }

    private function assertFailingMessage(): string
    {
        return implode("\n", $this->failedAssertingMessages);
    }
}
