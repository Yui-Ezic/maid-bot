<?php

declare(strict_types=1);

namespace App\Notification\Query\FindSubscriptionsByEventType;

class Query
{
    public function __construct(
        public string $eventType
    ) {
    }
}
