<?php

namespace Fefas\AssertPsrResponse\Assertions;

use Psr\Http\Message\ResponseInterface;
use PHPUnit\Framework\TestCase;

class StatusCodeAssertionTest extends TestCase
{
    /**
     * @test
     */
    public function isNotFailedIfResponseHasStatusCodeEqualsTheExpected(): void
    {
        $responseToAssert = $this->responseWithStatusCode(200);
        $statusCodeAssertion = new StatusCodeAssertion(200, $responseToAssert);

        $isFailed = $statusCodeAssertion->isFailed();

        $this->assertFalse($isFailed);
    }

    /**
     * @test
     */
    public function returnNullFailedMessageIfResponseHasStatusCodeEqualsTheExpected(): void
    {
        $responseToAssert = $this->responseWithStatusCode(200);
        $statusCodeAssertion = new StatusCodeAssertion(200, $responseToAssert);

        $nullFailedMessage = $statusCodeAssertion->failedMessage();

        $this->assertNull($nullFailedMessage);
    }

    /**
     * @test
     */
    public function isFailedIfResponseHasStatusCodeNotEqualsTheExpected(): void
    {
        $responseToAssert = $this->responseWithStatusCode(500);
        $statusCodeAssertion = new StatusCodeAssertion(200, $responseToAssert);

        $isFailed = $statusCodeAssertion->isFailed();

        $this->assertTrue($isFailed);
    }

    /**
     * @test
     */
    public function returnFailedMessageIfResponseHasStatusCodeNotEqualsTheExpected(): void
    {
        $responseToAssert = $this->responseWithStatusCode(500);
        $statusCodeAssertion = new StatusCodeAssertion(200, $responseToAssert);

        $failedMessage = $statusCodeAssertion->failedMessage();

        $this->assertEquals(
            'Failed asserting response status code \'500\' to the expected \'200\'',
            $failedMessage
        );
    }

    private function responseWithStatusCode(int $statusCode): ResponseInterface
    {
        $response = $this->createMock(ResponseInterface::class);
        $response
            ->method('getStatusCode')
            ->willReturn($statusCode);

        return $response;
    }
}
