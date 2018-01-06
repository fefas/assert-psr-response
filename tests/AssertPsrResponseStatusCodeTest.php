<?php

namespace Fefas\AssertPsrResponse;

use RuntimeException;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

class AssertPsrResponseStatusCodeTest extends TestCase
{
    /**
     * @test
     */
    public function dontThrowAnyExceptionWhenStatusCodeIsEqual(): void
    {
        $responseStub = $this->responseWithStatusCode(200);
        $assertPsrResponse = new AssertPsrResponse($responseStub);

        $assertPsrResponse->statusCodeToAssert(200);
        $assertResult = $assertPsrResponse->assert();

        $this->assertTrue($assertResult);
    }

    /**
     * @test
     */
    public function throwRuntimeExceptionWhenStatusCodeIsNotEqual(): void
    {
        $responseStub = $this->responseWithStatusCode(500);
        $assertPsrResponse = new AssertPsrResponse($responseStub);

        $assertPsrResponse->statusCodeToAssert(200);

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage(
            "Failed asserting response status code '500' to the expected '200'"
        );

        $assertPsrResponse->assert();
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
