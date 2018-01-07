<?php

namespace Fefas\AssertPsrResponse;

use RuntimeException;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class AssertPsrResponseJsonBodyContentTest extends TestCase
{
    /**
     * @test
     */
    public function dontThrowAnyExceptionWhenStatusCodeIsEqual(): void
    {
        $responseStub = $this->responseWithJsonBodyContent('[1,2,3]');
        $assertPsrResponse = new AssertPsrResponse($responseStub);

        $assertPsrResponse->addJsonBodyContentToAssert('[1,2,3]');
        $assertResult = $assertPsrResponse->assert();

        $this->assertTrue($assertResult);
    }

    /**
     * @test
     */
    public function throwRuntimeExceptionWhenStatusCodeIsNotEqual(): void
    {
        $responseStub = $this->responseWithJsonBodyContent('[1,3]');
        $assertPsrResponse = new AssertPsrResponse($responseStub);

        $assertPsrResponse->addJsonBodyContentToAssert('[1,2]');

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage(
            "Failed asserting response json body content '[1,3]' to the expected '[1,2]'"
        );

        $assertPsrResponse->assert();
    }

    private function responseWithJsonBodyContent(string $jsonBodyContent): ResponseInterface
    {
        $body = $this->createMock(StreamInterface::class);
        $body
            ->method('getContents')
            ->willReturn($jsonBodyContent);

        $response = $this->createMock(ResponseInterface::class);
        $response
            ->method('getBody')
            ->willReturn($body);

        return $response;
    }
}
