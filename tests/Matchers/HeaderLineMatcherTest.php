<?php

namespace Fefas\AssertPsrResponse\Matchers;

use PHPUnit\Framework\TestCase;
use Fefas\AssertPsrResponse\PsrResponseDoubleBuilderTrait;

class HeaderLineMatcherTest extends TestCase
{
    use PsrResponseDoubleBuilderTrait;

    /**
     * @test
     */
    public function doesMatchIfResponseHeaderLineEqualsTheExpected(): void
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
    public function returnNullMismatchMessageIfResponseHeaderLineEqualsTheExpected(): void
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
    public function doesNotMatchIfResponseHeaderLineNotEqualsTheExpected(): void
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
    public function returnMismatchMessageIfResponseHeaderLineNotEqualsTheExpected(): void
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
