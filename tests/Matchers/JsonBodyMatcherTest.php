<?php

namespace Bauhaus\AssertPsrResponse\Matchers;

use Bauhaus\AssertPsrResponse\TestCase;

class JsonBodyMatcherTest extends TestCase
{
    /**
     * @test
     */
    public function matchIfResponseJsonBodyIsEqualToTheExpected(): void
    {
        $responseToAssert = $this->responseWithJsonBody('[1,2,3]');
        $jsonBodyMatcher = new JsonBodyMatcher('[1,2,3]', $responseToAssert);

        $match = $jsonBodyMatcher->match();

        $this->assertTrue($match);
    }

    /**
     * @test
     */
    public function returnNullMismatchMessageIfResponseJsonBodyIsEqualToTheExpected(): void
    {
        $responseToAssert = $this->responseWithJsonBody('[1,2,3]');
        $jsonBodyMatcher = new JsonBodyMatcher('[1,2,3]', $responseToAssert);

        $nullMismatchMessage = $jsonBodyMatcher->mismatchMessage();

        $this->assertNull($nullMismatchMessage);
    }

    /**
     * @test
     */
    public function doesNotMatchIfResponseJsonBodyIsNotEqualToTheExpected(): void
    {
        $responseToAssert = $this->responseWithJsonBody('[1,2,3]');
        $jsonBodyMatcher = new JsonBodyMatcher('[1,2]', $responseToAssert);

        $match = $jsonBodyMatcher->match();

        $this->assertFalse($match);
    }

    /**
     * @test
     */
    public function returnMismatchMessageIfResponseJsonBodyIsNotEqualToTheExpected(): void
    {
        $responseToAssert = $this->responseWithJsonBody('[1,2,3]');
        $jsonBodyMatcher = new JsonBodyMatcher('[1,2]', $responseToAssert);

        $mismatchMessage = $jsonBodyMatcher->mismatchMessage();

        $this->assertEquals(
            'Failed matching response json body \'[1,2,3]\' with the expected \'[1,2]\'',
            $mismatchMessage
        );
    }
}
