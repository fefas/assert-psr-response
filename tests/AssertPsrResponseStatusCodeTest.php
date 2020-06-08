<?php

namespace Bauhaus\AssertPsrResponse;

class AssertPsrResponseStatusCodeTest extends TestCase
{
    /**
     * @test
     */
    public function doNotThrowAnyExceptionWhenStatusCodeEqualsTheExpected(): void
    {
        $responseStub = $this->responseWithStatus(200);
        $assertPsrResponse = new AssertPsrResponse($responseStub);

        $assertPsrResponse->matchStatusCode(200);
        $assertResult = $assertPsrResponse->assert();

        $this->assertTrue($assertResult);
    }

    /**
     * @test
     */
    public function throwRuntimeExceptionWhenStatusCodeNotEqualsTheExpected(): void
    {
        $expectedExceptionMessage = <<<MSG
Failed matching response status code '500' with the expected '200'
MSG;
        $responseStub = $this->responseWithStatus(500);
        $assertPsrResponse = new AssertPsrResponse($responseStub);

        $assertPsrResponse->matchStatusCode(200);

        $this->expectExceptionMessage($expectedExceptionMessage);
        $assertPsrResponse->assert();
    }
}
