<?php

namespace Bauhaus\AssertPsrResponse\Matchers;

use Bauhaus\AssertPsrResponse\Exceptions\MalformedJsonException;
use Psr\Http\Message\ResponseInterface as PsrResponse;
use Fefas\Jsoncoder\Json;
use InvalidArgumentException;

final class JsonBody implements Matcher
{
    private const MISMATCH_MESSAGE =
        'Actual response json body \'%s\' is not equal to the expected \'%s\'';

    private Json $expected;

    private function __construct(string $expected)
    {
        $this->expected = $this->handleJson($expected);
    }

    public function match(PsrResponse $psrResponse): bool
    {
        $actual = $this->handleJson($this->extractBody($psrResponse));

        return $this->expected->isEqualTo($actual);
    }

    public function mismatchMessage(PsrResponse $psrResponse): string
    {
        return sprintf(self::MISMATCH_MESSAGE, $this->extractBody($psrResponse), $this->expected);
    }

    public static function equalTo(string $expected): self
    {
        return new self($expected);
    }

    private function extractBody(PsrResponse $psrResponse): string
    {
        return (string) $psrResponse->getBody();
    }

    private function handleJson(string $jsonString): Json
    {
        try {
            return Json::createFromString($jsonString);
        } catch (InvalidArgumentException $ex) {
            throw new MalformedJsonException($jsonString, $ex);
        }
    }
}
