<?php

declare(strict_types=1);

namespace App\Profanity\Detector;

class Profanity
{
    public function __construct(
        private string $value,
    )
    {
    }

    public function getValue(): string
    {
        return $this->value;
    }
}