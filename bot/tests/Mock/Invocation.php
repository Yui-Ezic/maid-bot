<?php

declare(strict_types=1);

namespace Test\Mock;

class Invocation
{
    public function __construct(
        private string $methodName,
        private array $arguments
    ) {
    }

    public function getMethodName(): string
    {
        return $this->methodName;
    }

    public function getArguments(): array
    {
        return $this->arguments;
    }
}
