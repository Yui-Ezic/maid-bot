<?php

declare(strict_types=1);

namespace App\Profanity\Detector;

class Message
{
    public function __construct(
        public string $text
    )
    {}
}