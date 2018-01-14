<?php

namespace Fefas\AssertPsrResponse\Matchers;

use PHPUnit\Framework\TestCase;
use Fefas\AssertPsrResponse\PsrResponseDoubleBuilder;

class StatusCodeMatcherTest extends TestCase
{
    use PsrResponseDoubleBuilder;

    /**
     * @test
     */
    public function doesMatchIfResponseStatusCodeEqualsTheExpected(): void
    {
        $responseToAssert = $this->responseWithStatusCode(200);
        $statusCodeMatcher = new StatusCodeMatcher(200, $responseToAssert);

        $match = $statusCodeMatcher->match();

        $this->assertTrue($match);
    }

    /**
     * @test
     */
    public function returnNullMismatchMessageIfResponseStatusCodeEqualsTheExpected(): void
    {
        $responseToAssert = $this->responseWithStatusCode(200);
        $statusCodeMatcher = new StatusCodeMatcher(200, $responseToAssert);

        $nullMismatchMessage = $statusCodeMatcher->mismatchMessage();

        $this->assertNull($nullMismatchMessage);
    }

    /**
     * @test
     */
    public function doesNotMatchIfResponseStatusCodeNotEqualsTheExpected(): void
    {
        $responseToAssert = $this->responseWithStatusCode(500);
        $statusCodeMatcher = new StatusCodeMatcher(200, $responseToAssert);

        $match = $statusCodeMatcher->match();

        $this->assertFalse($match);
    }

    /**
     * @test
     */
    public function returnMismatchMessageIfResponseStatusCodeNotEqualsTheExpected(): void
    {
        $responseToAssert = $this->responseWithStatusCode(500);
        $statusCodeMatcher = new StatusCodeMatcher(200, $responseToAssert);

        $mismatchMessage = $statusCodeMatcher->mismatchMessage();

        $this->assertEquals(
            'Failed matching response status code \'500\' with the expected \'200\'',
            $mismatchMessage
        );
    }
}
