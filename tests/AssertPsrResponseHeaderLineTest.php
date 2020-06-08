<?php

namespace Bauhaus\AssertPsrResponse;

class AssertPsrResponseHeaderLineTest extends TestCase
{
    /**
     * @test
     */
    public function doNotThrowAnyExceptionIfHeaderLineEqualsTheExpected(): void
    {
        $responseStub = $this->responseWithHeaderLine('Content-Type', 'text/html');
        $assertPsrResponse = new AssertPsrResponse($responseStub);

        $assertPsrResponse->matchHeaderLine('Content-Type', 'text/html');

        $assertResult = $assertPsrResponse->assert();

        $this->assertTrue($assertResult);
    }

    /**
     * @test
     */
    public function throwRuntimeExceptionWhenHeaderLineNotEqualsTheExpected(): void
    {
        $expectedExceptionMessage = <<<MSG
Failed matching response header line 'Content-Type' 'text/html' with the expected 'application/json'
MSG;
        $responseStub = $this->responseWithHeaderLine('Content-Type', 'text/html');
        $assertPsrResponse = new AssertPsrResponse($responseStub);

        $assertPsrResponse->matchHeaderLine('Content-Type', 'application/json');

        $this->expectExceptionMessage($expectedExceptionMessage);
        $assertPsrResponse->assert();
    }
}
