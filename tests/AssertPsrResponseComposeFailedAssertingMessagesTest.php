<?php

namespace Fefas\AssertPsrResponse;

use PHPUnit\Framework\TestCase;

class AssertPsrResponseComposeFailedAssertingMessagesTest extends TestCase
{
    use PsrResponseDoubleBuilderTrait;
    use AssertExceptionTrait;

    /**
     * @test
     */
    public function throwRuntimeExceptionWithMoreThanOneFailedAssertingMessages(): void
    {
        $expectedExceptionMessage = <<<MSG
Failed matching response status code '500' with the expected '200'
Failed matching response header line 'Content-Type' 'text/html' with the expected 'application/json'
MSG
        $responseStub = $this->responseWithStatusAndHeaderLine(500, 'Content-Type', 'text/html');
        $assertPsrResponse = new AssertPsrResponse($responseStub);

        $assertPsrResponse->matchStatusCode(200);
        $assertPsrResponse->matchHeaderLine('Content-Type', 'application/json');

        $this->expectExceptionMessage($expectedExceptionMessage);
        $assertPsrResponse->assert();
    }
}
