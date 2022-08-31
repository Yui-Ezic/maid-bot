<?php

declare(strict_types=1);

namespace App\Notification\Command\Unsubscribe;

class Command
{
    public function __construct(
        public string $subscriptionId
    ) {
    }
}
