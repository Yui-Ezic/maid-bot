<?php

declare(strict_types=1);

namespace Test\Mock\Expectation;

use Test\Mock\Expectation\Exception\ExpectationException;
use Test\Mock\Invocation;

class CallbackExpectation implements Expectation
{
    public function __construct(
        private string $methodName,
        private int $invocationNumber,
        /** @var callable(array):bool $callback */
        private $callback
    ) {
    }

    public function assert(array $invocations): void
    {
        $invocation = $this->getInvocation($invocations);
        if (!($this->callback)($invocation->getArguments())) {
            throw new ExpectationException("Fail asserting {$this->methodName} arguments on {$this->invocationNumber} invocation.");
        }
    }

    /**
     * @param Invocation[] $invocations
     */
    private function getInvocation(array $invocations): Invocation
    {
        $invocationCount = 0;
        foreach ($invocations as $invocation) {
            if ($invocation->getMethodName() === $this->methodName) {
                ++$invocationCount;
            }
            if ($invocationCount === $this->invocationNumber) {
                return $invocation;
            }
        }
        throw new ExpectationException("{$this->methodName} invoked less than {$this->invocationNumber} times.");
    }
}
