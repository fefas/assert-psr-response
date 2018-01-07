<?php

namespace Fefas\AssertPsrResponse;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\StreamInterface as Stream;

trait PsrResponseDoubleBuilder
{
    private function responseWithStatusCode(int $statusCode): Response
    {
        $response = $this->createMock(Response::class);
        $response
            ->method('getStatusCode')
            ->willReturn($statusCode);

        return $response;
    }

    private function responseWithHeaderLine(
        string $headerName,
        string $headerValue
    ): Response {
        $response = $this->createMock(Response::class);
        $response
            ->method('getHeaderLine')
            ->with($this->equalTo($headerName))
            ->willReturn($headerValue);

        return $response;
    }

    private function responseWithJsonBody(string $jsonBody): Response
    {
        $responseBody = $this->createMock(Stream::class);
        $responseBody
            ->method('getContents')
            ->willReturn($jsonBody);

        $response = $this->createMock(Response::class);
        $response
            ->method('getBody')
            ->willReturn($responseBody);

        return $response;
    }

    private function responseWithStatusCodeAndHeaderLine(
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
