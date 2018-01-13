<?php

namespace Fefas\AssertPsrResponse\Assertions;

use Psr\Http\Message\ResponseInterface as Response;
use Fefas\Jsoncoder\Json;

class JsonBodyAssertion implements Assertion
{
    private const FAILED_MESSAGE_TEMPLATE =
        'Failed asserting response json body \'%s\' to the expected \'%s\'';

    private $isFailed = false;
    private $failedMessage;

    public function __construct(string $expectedJsonBody, Response $responseToAssert)
    {
        $jsonBodyToAssert = $responseToAssert->getBody()->getContents();

        $expectedJson = Json::createFromString($expectedJsonBody);
        $jsonToAssert = Json::createFromString($jsonBodyToAssert);

        if ($jsonToAssert->isEqualTo($expectedJson)) {
            return;
        }

        $this->isFailed = true;

        $this->failedMessage = $this->buildFailedMessage(
            $expectedJsonBody,
            $jsonBodyToAssert
        );
    }

    public function isFailed(): bool
    {
        return $this->isFailed;
    }

    public function failedMessage(): ?string
    {
        return $this->failedMessage;
    }

    public function buildFailedMessage(string $expected, string $asserted): string
    {
        return sprintf(self::FAILED_MESSAGE_TEMPLATE, $asserted, $expected);
    }
}
