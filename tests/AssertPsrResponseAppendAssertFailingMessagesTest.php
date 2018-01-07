<?php

namespace Fefas\AssertPsrResponse;

use RuntimeException;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

class AssertPsrResponseAppendAssertFailingMessagesTest extends TestCase
{
    /**
     * @test
     */
    public function throwRuntimeExceptionWithMoreThanOneAssertFailingMessages(): void
    {
        $responseStub = $this->responseWithStatusCodeAndHeaderLine(
            500,
            'Content-Type',
            'text/html'
        );
        $assertPsrResponse = new AssertPsrResponse($responseStub);

        $assertPsrResponse->addStatusCodeToAssert(200);
        $assertPsrResponse->addHeaderLineToAssert('Content-Type', 'application/json');

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage(<<<MSG
Failed asserting response status code '500' to the expected '200'
Failed asserting response header line 'Content-Type' 'text/html' to the expected 'application/json'
MSG
        );

        $assertPsrResponse->assert();
    }

    private function responseWithStatusCodeAndHeaderLine(
        int $statusCode,
        string $headerName,
        string $headerValue
    ): ResponseInterface {
        $response = $this->createMock(ResponseInterface::class);

        $response
            ->method('getStatusCode')
            ->willReturn($statusCode);

        $response
            ->method('getHeaderLine')
            ->willReturn($headerValue);

        return $response;
    }
}
