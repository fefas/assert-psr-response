<?php

namespace Fefas\AssertPsrResponse\Assertions;

abstract class EqualsAssertion implements Assertion
{
    private $isFailed;
    private $failedMessage;

    public function __construct($expected, $toAssert, array $messageParams)
    {
        $this->isFailed = $expected != $toAssert;

        if ($this->isFailed()) {
            $this->failedMessage = $this->buildFailedMessage($messageParams);
        }
    }

    public function isFailed(): bool
    {
        return $this->isFailed;
    }

    public function failedMessage(): ?string
    {
        return $this->failedMessage;
    }

    private function buildFailedMessage(array $params): string
    {
        return vsprintf($this->failedMessageTemplate(), $params);
    }

    abstract protected function failedMessageTemplate(): string;
}
