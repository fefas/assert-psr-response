<?php

namespace Bauhaus\AssertPsrResponse\Matchers;

use Bauhaus\AssertPsrResponse\TestCase;

class StatusCodeMatcherTest extends TestCase
{
    /**
     * @test
     */
    public function matchIfResponseStatusCodeIsEqualToTheExpected(): void
    {
        $responseToAssert = $this->responseWithStatus(200);
        $statusCodeMatcher = new StatusCodeMatcher(200, $responseToAssert);

        $match = $statusCodeMatcher->match();

        $this->assertTrue($match);
    }

    /**
     * @test
     */
    public function returnNullMismatchMessageIfResponseStatusCodeEqualsTheExpected(): void
    {
        $responseToAssert = $this->responseWithStatus(200);
        $statusCodeMatcher = new StatusCodeMatcher(200, $responseToAssert);

        $nullMismatchMessage = $statusCodeMatcher->mismatchMessage();

        $this->assertNull($nullMismatchMessage);
    }

    /**
     * @test
     */
    public function doesNotMatchIfResponseStatusCodeIsNotEqualToTheExpected(): void
    {
        $responseToAssert = $this->responseWithStatus(500);
        $statusCodeMatcher = new StatusCodeMatcher(200, $responseToAssert);

        $match = $statusCodeMatcher->match();

        $this->assertFalse($match);
    }

    /**
     * @test
     */
    public function returnMismatchMessageIfResponseStatusCodeIsNotEqualToTheExpected(): void
    {
        $responseToAssert = $this->responseWithStatus(500);
        $statusCodeMatcher = new StatusCodeMatcher(200, $responseToAssert);

        $mismatchMessage = $statusCodeMatcher->mismatchMessage();

        $this->assertEquals(
            'Failed matching response status code \'500\' with the expected \'200\'',
            $mismatchMessage
        );
    }
}
