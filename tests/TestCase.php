<?php

namespace Bauhaus\AssertPsrResponse;

use PHPUnit\Framework\TestCase as PhpUnitTestCase;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\StreamInterface as Stream;

abstract class TestCase extends PhpUnitTestCase
{
    protected function expectAssertPsrResponseExceptionWithMessage(string $message): void
    {
        $message = str_replace('/', '\/', $message);

        $this->expectException(PsrResponseAssertionException::class);
        $this->expectExceptionMessageMatches("/^$message$/");
    }

    protected function response(): Response
    {
        return $this->createMock(Response::class);
    }

    protected function responseWithStatus(int $statusCode): Response
    {
        $response = $this->createMock(Response::class);
        $response
            ->method('getStatusCode')
            ->willReturn($statusCode);

        return $response;
    }

    protected function responseWithHeaderLine(string $headerName, string $headerValue): Response
    {
        $response = $this->createMock(Response::class);
        $response
            ->method('getHeaderLine')
            ->with($this->equalTo($headerName))
            ->willReturn($headerValue);

        return $response;
    }

    protected function responseWithJsonBody(string $jsonBody): Response
    {
        $responseBody = $this->createMock(Stream::class);
        $responseBody
            ->method('__toString')
            ->willReturn($jsonBody);

        $response = $this->createMock(Response::class);
        $response
            ->method('getBody')
            ->willReturn($responseBody);

        return $response;
    }

    protected function responseWithStatusAndHeaderLine(
        int $statusCode,
        string $headerName,
        string $headerValue
    ): Response {
        $response = $this->createMock(Response::class);

        $response
            ->method('getStatusCode')
            ->willReturn($statusCode);

        $response
            ->method('getHeaderLine')
            ->with($this->equalTo($headerName))
            ->willReturn($headerValue);

        return $response;
    }
}
