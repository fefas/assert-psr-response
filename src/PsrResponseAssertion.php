<?php

namespace Bauhaus\AssertPsrResponse;

use Bauhaus\AssertPsrResponse\Exceptions\PsrResponseAssertionException;
use Bauhaus\AssertPsrResponse\Matchers\Matcher;
use Psr\Http\Message\ResponseInterface as PsrResponse;

final class PsrResponseAssertion
{
    /** @var Matcher[] */
    private array $matchers = [];

    public static function with(Matcher ...$matchers): self
    {
        $self = new self();
        $self->matchers = $matchers;

        return $self;
    }

    public function assert(PsrResponse $response): bool
    {
        if ($this->hasNoMismatcher($response)) {
            return true;
        }

        throw new PsrResponseAssertionException($this->buildMismatchMessages($response));
    }

    private function hasNoMismatcher(PsrResponse $response): bool
    {
        return $this->findMismatchers($response) === [];
    }

    private function buildMismatchMessages(PsrResponse $response): array
    {
        $mismatchers = $this->findMismatchers($response);
        return array_map(fn(Matcher $m) => $m->mismatchMessage($response), $mismatchers);
    }

    private function findMismatchers(PsrResponse $response): array
    {
        return array_filter($this->matchers, fn(Matcher $m) => !$m->match($response));
    }
}
