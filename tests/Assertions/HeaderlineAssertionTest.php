<?php

namespace Fefas\AssertPsrResponse\Assertions;

use Psr\Http\Message\ResponseInterface;
use PHPUnit\Framework\TestCase;

class HeaderLineAssertionTest extends TestCase
{
    /**
     * @test
     */
    public function isNotFailedIfResponseHasHeaderLineEqualsTheExpected(): void
    {
        $responseToAssert = $this->responseWithHeaderLine('Content-Type', 'text/html');
        $headerLineAssertion = new HeaderLineAssertion(
            'text/html',
            'Content-Type',
            $responseToAssert
        );

        $isFailed = $headerLineAssertion->isFailed();

        $this->assertFalse($isFailed);
    }

    /**
     * @test
     */
    public function returnNullFailedMessageIfResponseHasHeaderLineEqualsTheExpected(): void
    {
        $responseToAssert = $this->responseWithHeaderLine('Content-Type', 'text/html');
        $headerLineAssertion = new HeaderLineAssertion(
            'text/html',
            'Content-Type',
            $responseToAssert
        );

        $nullFailedMessage = $headerLineAssertion->failedMessage();

        $this->assertNull($nullFailedMessage);
    }

    /**
     * @test
     */
    public function isFailedIfResponseHasHeaderLineNotEqualsTheExpected(): void
    {
        $responseToAssert = $this->responseWithHeaderLine('Content-Type', 'text/html');
        $headerLineAssertion = new HeaderLineAssertion(
            'application/json',
            'Content-Type',
            $responseToAssert
        );

        $isFailed = $headerLineAssertion->isFailed();

        $this->assertTrue($isFailed);
    }

    /**
     * @test
     */
    public function returnFailedMessageIfResponseHasHeaderLineNotEqualsTheExpected(): void
    {
        $responseToAssert = $this->responseWithHeaderLine('Content-Type', 'text/html');
        $headerLineAssertion = new HeaderLineAssertion(
            'application/json',
            'Content-Type',
            $responseToAssert
        );

        $failedMessage = $headerLineAssertion->failedMessage();

        $this->assertEquals(
            'Failed asserting response header line \'Content-Type\' \'text/html\' to the expected \'application/json\'',
            $failedMessage
        );
    }

    private function responseWithHeaderLine(
        string $headerName,
        string $headerValue
    ): ResponseInterface {
        $response = $this->createMock(ResponseInterface::class);
        $response
            ->method('getHeaderLine')
            ->with($this->equalTo($headerName))
            ->willReturn($headerValue);

        return $response;
    }
}
