<?php

declare(strict_types=1);

namespace Test\Mock\Expectation\Exception;

use RuntimeException;

class ExpectationException extends RuntimeException
{
    public function __construct(string $message)
    {
        parent::__construct($message, 0, null);
    }
}
