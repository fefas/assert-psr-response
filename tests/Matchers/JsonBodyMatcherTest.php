<?php

namespace Fefas\AssertPsrResponse\Matchers;

use PHPUnit\Framework\TestCase;
use Fefas\AssertPsrResponse\PsrResponseDoubleBuilder;

class JsonBodyMatcherTest extends TestCase
{
    use PsrResponseDoubleBuilder;

    /**
     * @test
     */
    public function doesMatchIfResponseJsonBodyEqualsTheExpected(): void
    {
        $responseToAssert = $this->responseWithJsonBody('[1,2,3]');
        $jsonBodyMatcher = new JsonBodyMatcher('[1,2,3]', $responseToAssert);

        $match = $jsonBodyMatcher->match();

        $this->assertTrue($match);
    }

    /**
     * @test
     */
    public function returnNullMismatchMessageIfResponseJsonBodyEqualsTheExpected(): void
    {
        $responseToAssert = $this->responseWithJsonBody('[1,2,3]');
        $jsonBodyMatcher = new JsonBodyMatcher('[1,2,3]', $responseToAssert);

        $nullMismatchMessage = $jsonBodyMatcher->mismatchMessage();

        $this->assertNull($nullMismatchMessage);
    }

    /**
     * @test
     */
    public function doesNotMatchIfResponseJsonBodyNotEqualsTheExpected(): void
    {
        $responseToAssert = $this->responseWithJsonBody('[1,2,3]');
        $jsonBodyMatcher = new JsonBodyMatcher('[1,2]', $responseToAssert);

        $match = $jsonBodyMatcher->match();

        $this->assertFalse($match);
    }

    /**
     * @test
     */
    public function returnMismatchMessageIfResponseJsonBodyNotEqualsTheExpected(): void
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
