<?php

declare(strict_types=1);

namespace Test\Mock;

use Test\Mock\Expectation\Expectation;

trait ExpectableTrait
{
    /** @var Expectation[] */
    private array $expectations = [];

    /** @var Invocation[] */
    private array $invocations = [];

    public function expect(Expectation $expectation): self
    {
        $this->expectations[] = $expectation;
        return $this;
    }

    public function assertExpectations(): void
    {
        foreach ($this->expectations as $expectation) {
            $expectation->assert($this->invocations);
        }
    }

    public function reset(): void
    {
        $this->expectations = [];
        $this->invocations = [];
    }

    protected function addInvocation(Invocation $invocation): void
    {
        $this->invocations[] = $invocation;
    }
}
