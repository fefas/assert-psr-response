<?php

namespace Bauhaus\AssertPsrResponse\Matchers;

use Bauhaus\AssertPsrResponse\TestCase;

class JsonBodyTest extends TestCase
{
    /**
     * @test
     */
    public function matchIfResponseJsonBodyIsEqualToTheExpected(): void
    {
        $responseToAssert = $this->responseWithJsonBody('[1,2,3]');
        $jsonBodyMatcher = JsonBody::equalTo('[1,2,3]');

        $match = $jsonBodyMatcher->match($responseToAssert);

        $this->assertTrue($match);
    }

    /**
     * @test
     */
    public function doNotMatchIfResponseJsonBodyIsNotEqualToTheExpected(): void
    {
        $responseToAssert = $this->responseWithJsonBody('[1,2,3]');
        $jsonBodyMatcher = JsonBody::equalTo('[1,2]');

        $match = $jsonBodyMatcher->match($responseToAssert);

        $this->assertFalse($match);
    }

    /**
     * @test
     */
    public function returnMismatchMessageAccordingToExpectedAndActualValues(): void
    {
        $responseToAssert = $this->responseWithJsonBody('[1,2,3]');
        $jsonBodyMatcher = JsonBody::equalTo('[1,2]');

        $mismatchMessage = $jsonBodyMatcher->mismatchMessage($responseToAssert);

        $expected = 'Actual response json body \'[1,2,3]\' is not equal to the expected \'[1,2]\'';
        $this->assertEquals($expected, $mismatchMessage);
    }
}
