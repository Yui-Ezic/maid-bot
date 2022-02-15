<?php

declare(strict_types=1);

namespace Test\Mock\Expectation;

use Test\Mock\Expectation\Exception\ExpectationException;
use Test\Mock\Invocation;

class InvokeMethodExpectation implements Expectation
{
    public function __construct(
        private string $methodName,
        private int $expectedInvocationsCount
    ) {
    }

    public function assert(array $invocations): void
    {
        $actualInvocationsCount = $this->countActualInvocations($invocations);
        if ($this->expectedInvocationsCount !== $actualInvocationsCount) {
            $this->throwExpectationException($actualInvocationsCount);
        }
    }

    /**
     * @param Invocation[] $invocations
     */
    private function countActualInvocations(array $invocations): int
    {
        $actualInvocationsCount = 0;
        foreach ($invocations as $execution) {
            if ($execution->getMethodName() === $this->methodName) {
                ++$actualInvocationsCount;
            }
        }
        return $actualInvocationsCount;
    }

    private function throwExpectationException(int $actualInvocationsCount): void
    {
        $message = "Fail asserting that {$this->methodName} invoked {$this->expectedInvocationsCount} times.";
        $message .= "Actual {$actualInvocationsCount}";
        throw new ExpectationException($message);
    }
}
