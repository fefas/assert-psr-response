<?php

namespace Fefas\AssertPsrResponse\Assertions;

use Psr\Http\Message\ResponseInterface as Response;

class JsonBodyAssertion implements Assertion
{
    private const FAILED_MESSAGE_TEMPLATE =
        'Failed asserting response json body \'%s\' to the expected \'%s\'';

    private $isFailed;
    private $failedMessage;

    public function __construct(string $expectedJsonBody, Response $responseToAssert)
    {
        $jsonBodyToAssert = $responseToAssert->getBody()->getContents();

        try {
            assertJsonStringEqualsJsonString($expectedJsonBody, $jsonBodyToAssert);

            $this->isFailed = false;
        } catch (\Exception $phpunitException) {
        //    $jsonDiff = $phpunitException->getComparisonFailure()->getDiff();

            $this->isFailed = true;

            $this->failedMessage = $this->buildFailedMessage(
                $expectedJsonBody,
                $jsonBodyToAssert
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

    public function buildFailedMessage(string $expected, string $asserted): string
    {
        return sprintf(self::FAILED_MESSAGE_TEMPLATE, $asserted, $expected);
    }
}
