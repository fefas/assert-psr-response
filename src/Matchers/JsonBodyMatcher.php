<?php

namespace Fefas\AssertPsrResponse\Matchers;

use Psr\Http\Message\ResponseInterface as Response;
use Fefas\Jsoncoder\Json;

class JsonBodyMatcher implements Matcher
{
    private const MISMATCH_MESSAGE_TEMPLATE =
        'Failed matching response json body \'%s\' with the expected \'%s\'';

    private $match = true;
    private $mismatchMessage;

    public function __construct(string $expectedJsonBody, Response $responseToAssert)
    {
        $jsonBodyToAssert = $responseToAssert->getBody()->getContents();

        $expectedJson = Json::createFromString($expectedJsonBody);
        $jsonToAssert = Json::createFromString($jsonBodyToAssert);

        if ($jsonToAssert->isEqualTo($expectedJson)) {
            return;
        }

        $this->match = false;

        $this->mismatchMessage = $this->buildMismatchMessage(
            $expectedJsonBody,
            $jsonBodyToAssert
        );
    }

    public function match(): bool
    {
        return $this->match;
    }

    public function mismatchMessage(): ?string
    {
        return $this->mismatchMessage;
    }

    public function buildMismatchMessage(string $expected, string $asserted): string
    {
        return sprintf(self::MISMATCH_MESSAGE_TEMPLATE, $asserted, $expected);
    }
}
