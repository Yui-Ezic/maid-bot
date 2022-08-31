<?php

declare(strict_types=1);

namespace App\Notification\Query\FindSubscriptionsBySubscriberId;

class Query
{
    public function __construct(
        public string $subscriberId,
    ) {
    }
}
