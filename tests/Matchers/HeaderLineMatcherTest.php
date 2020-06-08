<?php

namespace Bauhaus\AssertPsrResponse\Matchers;

use Bauhaus\AssertPsrResponse\TestCase;

class HeaderLineMatcherTest extends TestCase
{
    /**
     * @test
     */
    public function matchIfResponseHeaderLineIsEqualToTheExpected(): void
    {
        $responseToAssert = $this->responseWithHeaderLine('Content-Type', 'text/html');
        $headerLineMatcher = new HeaderLineMatcher(
            'text/html',
            'Content-Type',
            $responseToAssert
        );

        $match = $headerLineMatcher->match();

        $this->assertTrue($match);
    }

    /**
     * @test
     */
    public function returnNullMismatchMessageIfResponseHeaderLineIsEqualToTheExpected(): void
    {
        $responseToAssert = $this->responseWithHeaderLine('Content-Type', 'text/html');
        $headerLineMatcher = new HeaderLineMatcher(
            'text/html',
            'Content-Type',
            $responseToAssert
        );

        $nullMismatchMessage = $headerLineMatcher->mismatchMessage();

        $this->assertNull($nullMismatchMessage);
    }

    /**
     * @test
     */
    public function doesNotMatchIfResponseHeaderLineIsNotEqualToTheExpected(): void
    {
        $responseToAssert = $this->responseWithHeaderLine('Content-Type', 'text/html');
        $headerLineMatcher = new HeaderLineMatcher(
            'application/json',
            'Content-Type',
            $responseToAssert
        );

        $match = $headerLineMatcher->match();

        $this->assertFalse($match);
    }

    /**
     * @test
     */
    public function returnMismatchMessageIfResponseHeaderLineIsNotEqualToTheExpected(): void
    {
        $responseToAssert = $this->responseWithHeaderLine('Content-Type', 'text/html');
        $headerLineMatcher = new HeaderLineMatcher(
            'application/json',
            'Content-Type',
            $responseToAssert
        );
        $expectedMismatchMessage = <<<MSG
Failed matching response header line 'Content-Type' 'text/html' with the expected 'application/json'
MSG;

        $mismatchMessage = $headerLineMatcher->mismatchMessage();

        $this->assertEquals($expectedMismatchMessage, $mismatchMessage);
    }
}
