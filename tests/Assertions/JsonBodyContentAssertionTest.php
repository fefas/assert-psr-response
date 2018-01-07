<?php

namespace Fefas\AssertPsrResponse\Assertions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\StreamInterface as ResponseBody;
use PHPUnit\Framework\TestCase;

class JsonBodyAssertionTest extends TestCase
{
    /**
     * @test
     */
    public function isNotFailedIfResponseJsonBodyEqualsTheExpected(): void
    {
        $responseToAssert = $this->responseWithJsonBody('[1,2,3]');
        $jsonBodyAssertion = new JsonBodyAssertion('[1,2,3]', $responseToAssert);

        $isFailed = $jsonBodyAssertion->isFailed();

        $this->assertFalse($isFailed);
    }

    /**
     * @test
     */
    public function returnNullFailedMessageIfResponseJsonBodyEqualsTheExpected(): void
    {
        $responseToAssert = $this->responseWithJsonBody('[1,2,3]');
        $jsonBodyAssertion = new JsonBodyAssertion('[1,2,3]', $responseToAssert);

        $nullFailedMessage = $jsonBodyAssertion->failedMessage();

        $this->assertNull($nullFailedMessage);
    }

    /**
     * @test
     */
    public function isFailedIfResponseJsonBodyNotEqualsTheExpected(): void
    {
        $responseToAssert = $this->responseWithJsonBody('[1,2,3]');
        $jsonBodyAssertion = new JsonBodyAssertion('[1,2]', $responseToAssert);

        $isFailed = $jsonBodyAssertion->isFailed();

        $this->assertTrue($isFailed);
    }

    /**
     * @test
     */
    public function returnFailedMessageIfResponseJsonBodyNotEqualsTheExpected(): void
    {
        $responseToAssert = $this->responseWithJsonBody('[1,2,3]');
        $jsonBodyAssertion = new JsonBodyAssertion('[1,2]', $responseToAssert);

        $failedMessage = $jsonBodyAssertion->failedMessage();

        $this->assertEquals(
            'Failed asserting response json body \'[1,2,3]\' to the expected \'[1,2]\'',
            $failedMessage
        );
    }

    private function responseWithJsonBody(string $jsonBody): Response
    {
        $responseBody = $this->createMock(ResponseBody::class);
        $responseBody
            ->method('getContents')
            ->willReturn($jsonBody);

        $response = $this->createMock(Response::class);
        $response
            ->method('getBody')
            ->willReturn($responseBody);

        return $response;
    }
}
