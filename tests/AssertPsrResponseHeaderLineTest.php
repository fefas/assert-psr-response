<?php

namespace Fefas\AssertPsrResponse;

use RuntimeException;
use PHPUnit\Framework\TestCase;

class AssertPsrResponseHeaderLineTest extends TestCase
{
    use PsrResponseDoubleBuilder;

    /**
     * @test
     */
    public function dontThrowAnyExceptionIfHeaderLineEqualsTheExpected(): void
    {
        $responseStub = $this->responseWithHeaderLine('Content-Type', 'text/html');
        $assertPsrResponse = new AssertPsrResponse($responseStub);

        $assertPsrResponse->addHeaderLineToAssert('Content-Type', 'text/html');

        $assertResult = $assertPsrResponse->assert();

        $this->assertTrue($assertResult);
    }

    /**
     * @test
     */
    public function throwRuntimeExceptionWhenHeaderLineNotEqualsTheExpected(): void
    {
        $responseStub = $this->responseWithHeaderLine('Content-Type', 'text/html');
        $assertPsrResponse = new AssertPsrResponse($responseStub);

        $assertPsrResponse->addHeaderLineToAssert('Content-Type', 'application/json');

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage(
            "Failed asserting response header line 'Content-Type' 'text/html' to the expected 'application/json'"
        );

        $assertPsrResponse->assert();
    }
}
