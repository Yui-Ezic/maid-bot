<?php

declare(strict_types=1);

namespace App\Notification\Query\FindSubscriptionsByEventId;

class Query
{
    public function __construct(
        public string $eventId
    ) {
    }
}
