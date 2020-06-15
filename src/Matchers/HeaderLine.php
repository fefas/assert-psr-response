<?php

namespace Bauhaus\AssertPsrResponse\Matchers;

use Psr\Http\Message\ResponseInterface as PsrResponse;

class HeaderLine implements Matcher
{
    private const MISMATCH_MESSAGE =
        'Actual response header line \'%s\' \'%s\' is not equal to the expected \'%s\'';

    private string $headerName;
    private string $expected;

    private function __construct(string $headerName, string $expected)
    {
        $this->headerName = $headerName;
        $this->expected = $expected;
    }

    public function match(PsrResponse $psrResponse): bool
    {
        return $this->currentHeaderLine($psrResponse) === $this->expected;
    }

    public function mismatchMessage(PsrResponse $psrResponse): string
    {
        return sprintf(
            self::MISMATCH_MESSAGE,
            $this->headerName,
            $this->currentHeaderLine($psrResponse),
            $this->expected
        );
    }

    private function currentHeaderLine(PsrResponse $psrResponse): string
    {
        return $psrResponse->getHeaderLine($this->headerName);
    }

    public static function equalTo(string $headerName, string $expected): self
    {
        return new self($headerName, $expected);
    }
}
