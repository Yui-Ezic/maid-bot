<?php

declare(strict_types=1);

namespace App\Notification\Query\FindSubscriptionsBySubscriberId;

class Subscription
{
    public function __construct(
        public string $id,
        public string $eventTitle,
        public string $eventDescription
    ) {
    }
}
