<?php

declare(strict_types=1);

namespace Test\Mock\Expectation;

use Test\Mock\Invocation;

interface Expectation
{
    /**
     * @param Invocation[] $invocations
     */
    public function assert(array $invocations): void;
}
