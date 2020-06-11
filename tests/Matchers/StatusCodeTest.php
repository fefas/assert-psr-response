<?php

namespace Bauhaus\AssertPsrResponse\Matchers;

use Bauhaus\AssertPsrResponse\TestCase;

class StatusCodeTest extends TestCase
{
    /**
     * @test
     */
    public function matchIfResponseStatusCodeIsEqualToTheExpected(): void
    {
        $responseToAssert = $this->responseWithStatus(200);
        $statusCodeRule = StatusCode::equalTo(200);

        $match = $statusCodeRule->match($responseToAssert);

        $this->assertTrue($match);
    }

    /**
     * @test
     */
    public function doesNotMatchIfResponseStatusCodeIsNotEqualToTheExpected(): void
    {
        $responseToAssert = $this->responseWithStatus(500);
        $statusCodeMatcher = StatusCode::equalTo(200);

        $match = $statusCodeMatcher->match($responseToAssert);

        $this->assertFalse($match);
    }

    /**
     * @test
     */
    public function returnMismatchMessageAccordingToExpectedAndActualValues(): void
    {
        $responseToAssert = $this->responseWithStatus(500);
        $statusCode = StatusCode::equalTo(200);

        $mismatchMessage = $statusCode->mismatchMessage($responseToAssert);

        $expected = 'Actual response status code \'500\' is not equal to the expected \'200\'';
        $this->assertEquals($expected, $mismatchMessage);
    }
}
