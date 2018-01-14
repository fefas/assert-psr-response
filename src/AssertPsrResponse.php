<?php

namespace Fefas\AssertPsrResponse;

use Psr\Http\Message\ResponseInterface as Response;
use Fefas\AssertPsrResponse\Matchers\Matcher;
use Fefas\AssertPsrResponse\Matchers\HeaderLineMatcher;
use Fefas\AssertPsrResponse\Matchers\JsonBodyMatcher;
use Fefas\AssertPsrResponse\Matchers\StatusCodeMatcher;

class AssertPsrResponse
{
    private $response;
    private $matchers = [];

    public function __construct(Response $response)
    {
        $this->response = $response;
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

        throw new AssertPsrResponseException($mismatchMessages);
    }

    public function matchStatusCode(int $expected): void
    {
        $statusCodeMatcher = new StatusCodeMatcher($expected, $this->response);

        $this->addMatcher($statusCodeMatcher);
    }

    public function matchHeaderLine(string $headerName, string $expected): void
    {
        $headerLineMatcher = new HeaderLineMatcher($expected, $headerName, $this->response);

        $this->addMatcher($headerLineMatcher);
    }

    public function matchJsonBody(string $expected): void
    {
        $jsonBodyMatcher = new JsonBodyMatcher($expected, $this->response);

        $this->addMatcher($jsonBodyMatcher);
    }

    private function addMatcher(Matcher $matcher): void
    {
        $this->matchers[] = $matcher;
    }
}
