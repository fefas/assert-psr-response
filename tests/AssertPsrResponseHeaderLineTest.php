<?php

namespace Fefas\AssertPsrResponse;

use RuntimeException;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

class AssertPsrResponseHeaderLineTest extends TestCase
{
    /**
     * @test
     */
    public function dontThrowAnyExceptionWhenHeaderLineIsEqual(): void
    {
        $responseStub = $this->responseWithHeaderLine('Content-Type', 'text/html');
        $assertPsrResponse = new AssertPsrResponse($responseStub);

        $assertPsrResponse->headerLineToAssert('Content-Type', 'text/html');

        $assertResult = $assertPsrResponse->assert();

        $this->assertTrue($assertResult);
    }

    /**
     * @test
     */
    public function throwRuntimeExceptionWhenHeaderLineIsNotEqual(): void
    {
        $responseStub = $this->responseWithHeaderLine('Content-Type', 'text/html');
        $assertPsrResponse = new AssertPsrResponse($responseStub);

        $assertPsrResponse->headerLineToAssert('Content-Type', 'application/json');

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage(
            "Failed asserting response header line 'Content-Type' 'text/html' to the expected 'application/json'"
        );

        $assertPsrResponse->assert();
    }

    private function responseWithHeaderLine(
        string $headerName,
        string $headerValue
    ): ResponseInterface {
        $response = $this->createMock(ResponseInterface::class);
        $response
            ->method('getHeaderLine')
            ->willReturn($headerValue);

        return $response;
    }
}
