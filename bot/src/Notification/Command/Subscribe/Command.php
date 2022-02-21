<?php

declare(strict_types=1);

namespace App\Notification\Command\Subscribe;

class Command
{
    public function __construct(
        public string $subscriberId,
        public string $eventType,
    ) {
    }
}
