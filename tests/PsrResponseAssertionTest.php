<?php

namespace Bauhaus\AssertPsrResponse;

class PsrResponseAssertionTest extends TestCase
{
    /**
     * @test
     */
    public function returnTrueIfEverythingIsMatching(): void
    {
        $psrResponse = $this->response();
        $psrResponseAssertion = PsrResponseAssertion::with(
            new AlwaysMatching(),
            new AlwaysMatching(),
            new AlwaysMatching()
        );

        $matching = $psrResponseAssertion->assert($psrResponse);

        $this->assertTrue($matching);
    }

    /**
     * @test
     */
    public function throwPsrResponseAssertionExceptionWithCombinedMismatchMessagesIfThereAreNotMatchingMatchers(): void
    {
        $psrResponse = $this->response();
        $psrResponseAssertion = PsrResponseAssertion::with(
            new AlwaysMatching(),
            new AlwaysNotMatching(),
            new AlwaysNotMatching(),
            new AlwaysMatching()
        );

        $this->expectAssertPsrResponseExceptionWithMessage("always not matching\nalways not matching");

        $psrResponseAssertion->assert($psrResponse);
    }
}
