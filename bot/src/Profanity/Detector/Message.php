<?php

declare(strict_types=1);

namespace App\Profanity\Detector;

use Stringable;

class Message implements Stringable
{
    public function __construct(
        public string $text
    ) {
    }

    public function __toString()
    {
        return $this->text;
    }
}
