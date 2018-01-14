<?php

namespace Fefas\AssertPsrResponse;

use RuntimeException;
use Psr\Http\Message\ResponseInterface as Response;
use Fefas\AssertPsrResponse\Matchers\Matcher;
use Fefas\AssertPsrResponse\Matchers\HeaderLineMatcher;
use Fefas\AssertPsrResponse\Matchers\JsonBodyMatcher;
use Fefas\AssertPsrResponse\Matchers\StatusCodeMatcher;

class AssertPsrResponse
{
    private $responseToAssert;
    private $matchers = [];

    public function __construct(Response $responseToAssert)
    {
        $this->responseToAssert = $responseToAssert;
    }

    public function assert(): bool
    {
        $mismatchMessages = [];
        foreach ($this->matchers as $matcher) {
            if ($matcher->match()) {
                continue;
            }

            $mismatchMessages[] = $matcher->mismatchMessage();
        }

        if (empty($mismatchMessages)) {
            return true;
        }

        throw new RuntimeException(implode("\n", $mismatchMessages));
    }

    public function matchStatusCode(int $expectedStatusCode): void
    {
        $statusCodeMatcher = new StatusCodeMatcher(
            $expectedStatusCode,
            $this->responseToAssert
        );

        $this->addMatcher($statusCodeMatcher);
    }

    public function matchHeaderLine(string $headerName, string $expectedHeaderLine): void
    {
        $headerLineMatcher = new HeaderLineMatcher(
            $expectedHeaderLine,
            $headerName,
            $this->responseToAssert
        );

        $this->addMatcher($headerLineMatcher);
    }

    public function matchJsonBodyContent(string $expectedJsonBody): void
    {
        $jsonBodyMatcher = new JsonBodyMatcher(
            $expectedJsonBody,
            $this->responseToAssert
        );

        $this->addMatcher($jsonBodyMatcher);
    }

    private function addMatcher(Matcher $matcher): void
    {
        $this->matchers[] = $matcher;
    }
}
