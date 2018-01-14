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
        $responseStub = $this->responseWithStatusAndHeaderLine(500, 'Content-Type', 'text/html');
        $assertPsrResponse = new AssertPsrResponse($responseStub);

        $assertPsrResponse->matchStatusCode(200);
        $assertPsrResponse->matchHeaderLine('Content-Type', 'application/json');

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage(<<<MSG
Failed matching response status code '500' with the expected '200'
Failed matching response header line 'Content-Type' 'text/html' with the expected 'application/json'
MSG
        );

        $assertPsrResponse->assert();
    }
}
