<?php

namespace Fefas\AssertPsrResponse;

use RuntimeException;
use PHPUnit\Framework\TestCase;

class AssertPsrResponseComposeFailedAssertingMessagesTest extends TestCase
{
    use PsrResponseDoubleBuilder;

    /**
     * @test
     */
    public function throwRuntimeExceptionWithMoreThanOneFailedAssertingMessages(): void
    {
        $responseStub = $this->responseWithStatusCodeAndHeaderLine(500, 'Content-Type', 'text/html');
        $assertPsrResponse = new AssertPsrResponse($responseStub);

        $assertPsrResponse->addStatusCodeToAssert(200);
        $assertPsrResponse->addHeaderLineToAssert('Content-Type', 'application/json');

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage("
            Failed asserting response status code '500' to the expected '200'
            Failed asserting response header line 'Content-Type' 'text/html' to the expected 'application/json"
        );

        $assertPsrResponse->assert();
    }
}
