<?php

namespace Bauhaus\AssertPsrResponse;

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

    public function assert(PsrResponse $psrResponse): bool
    {
        $notMatching = $this->notMatching($psrResponse);

        if ([] === $notMatching) {
            return true;
        }

        $mismatchMessages = array_map(function (Matcher $matcher) use ($psrResponse): string {
            return $matcher->mismatchMessage($psrResponse);
        }, $notMatching);

        throw new PsrResponseAssertionException($mismatchMessages);
    }

    private function notMatching(PsrResponse $psrResponse): array
    {
        return array_filter($this->matchers, function (Matcher $matcher) use ($psrResponse): bool {
            return !$matcher->match($psrResponse);
        });
    }
}
