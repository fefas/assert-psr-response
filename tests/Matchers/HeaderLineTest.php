<?php

namespace Bauhaus\AssertPsrResponse\Matchers;

use Bauhaus\AssertPsrResponse\TestCase;

class HeaderLineTest extends TestCase
{
    /**
     * @test
     */
    public function matchIfResponseHeaderLineIsEqualToTheExpected(): void
    {
        $responseToAssert = $this->responseWithHeaderLine('Content-Type', 'text/html');
        $headerLine = HeaderLine::equalTo('Content-Type', 'text/html');

        $match = $headerLine->match($responseToAssert);

        $this->assertTrue($match);
    }

    /**
     * @test
     */
    public function doNotMatchIfResponseHeaderLineIsEqualToTheExpected(): void
    {
        $responseToAssert = $this->responseWithHeaderLine('Content-Type', 'text/html');
        $headerLine = HeaderLine::equalTo('Content-Type', 'application/json');

        $match = $headerLine->match($responseToAssert);

        $this->assertFalse($match);
    }

    /**
     * @test
     */
    public function returnMismatchMessageAccordingToExpectedAndActualValues(): void
    {
        $responseToAssert = $this->responseWithHeaderLine('Content-Type', 'text/html');
        $headerLine = HeaderLine::equalTo('Content-Type', 'application/json');

        $mismatchMessage = $headerLine->mismatchMessage($responseToAssert);

        $expected = 'Actual response header line \'Content-Type\' \'text/html\' is not equal to the expected \'application/json\'';
        $this->assertEquals($expected, $mismatchMessage);
    }
}
