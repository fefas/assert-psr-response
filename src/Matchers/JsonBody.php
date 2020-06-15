<?php

namespace Bauhaus\AssertPsrResponse\Matchers;

use Psr\Http\Message\ResponseInterface as PsrResponse;
use Fefas\Jsoncoder\Json;

class JsonBody implements Matcher
{
    private const MISMATCH_MESSAGE =
        'Actual response json body \'%s\' is not equal to the expected \'%s\'';

    private string $expected;

    public function __construct(string $expected)
    {
        $this->expected = $expected;
    }

    public function match(PsrResponse $psrResponse): bool
    {
        $expected = Json::createFromString($this->expected);
        $actual = Json::createFromString($this->extractBody($psrResponse));

        return $expected->isEqualTo($actual);
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
}
