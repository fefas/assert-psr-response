<?php

namespace Fefas\AssertPsrResponse\Matchers;

abstract class ScalarEqualsMatcher implements Matcher
{
    private $match;
    private $mismatchMessage;

    public function __construct($expected, $toAssert, array $mismatchMessageParams)
    {
        $this->match = $expected == $toAssert;

        if (false === $this->match()) {
            $this->mismatchMessage = $this->buildMismatchMessage($mismatchMessageParams);
        }
    }

    public function match(): bool
    {
        return $this->match;
    }

    public function mismatchMessage(): ?string
    {
        return $this->mismatchMessage;
    }

    private function buildMismatchMessage(array $params): string
    {
        return vsprintf($this->mismatchMessageTemplate(), $params);
    }

    abstract protected function mismatchMessageTemplate(): string;
}
