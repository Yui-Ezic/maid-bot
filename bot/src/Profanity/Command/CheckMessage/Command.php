<?php

declare(strict_types=1);

namespace App\Profanity\Command\CheckMessage;

class Command
{
    public function __construct(
        public string $text
    ) {
    }
}
