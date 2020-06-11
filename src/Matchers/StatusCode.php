<?php

namespace Bauhaus\AssertPsrResponse\Matchers;

use Psr\Http\Message\ResponseInterface as PsrResponse;

class StatusCode implements Matcher
{
    private const MISMATCH_MESSAGE =
        'Actual response status code \'%s\' is not equal to the expected \'%s\'';

    private int $expected;

    private function __construct(int $expected)
    {
        $this->expected = $expected;
    }

    public function match(PsrResponse $psrResponse): bool
    {
        return (int) $psrResponse->getStatusCode() === $this->expected;
    }

    public function mismatchMessage(PsrResponse $psrResponse): string
    {
        return sprintf(
            self::MISMATCH_MESSAGE,
            $psrResponse->getStatusCode(),
            $this->expected
        );
    }

    public static function equalTo(int $expected): self
    {
        return new self($expected);
    }
}
