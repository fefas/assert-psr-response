<?php

namespace Bauhaus\AssertPsrResponse;

class AssertPsrResponseJsonBodyTest extends TestCase
{
    /**
     * @test
     */
    public function doNotThrowAnyExceptionWhenJsonBodyEqualsTheExpected(): void
    {
        $responseStub = $this->responseWithJsonBody('[1,2,3]');
        $assertPsrResponse = new AssertPsrResponse($responseStub);

        $assertPsrResponse->matchJsonBody('[1,2,3]');
        $assertResult = $assertPsrResponse->assert();

        $this->assertTrue($assertResult);
    }

    /**
     * @test
     */
    public function throwRuntimeExceptionWhenJsonBodyEqualsTheExpected(): void
    {
        $expectedExceptionMessage = <<<MSG
Failed matching response json body '[1,3]' with the expected '[1,2]'
MSG;
        $responseStub = $this->responseWithJsonBody('[1,3]');
        $assertPsrResponse = new AssertPsrResponse($responseStub);

        $assertPsrResponse->matchJsonBody('[1,2]');

        $this->expectExceptionMessage($expectedExceptionMessage);
        $assertPsrResponse->assert();
    }
}
