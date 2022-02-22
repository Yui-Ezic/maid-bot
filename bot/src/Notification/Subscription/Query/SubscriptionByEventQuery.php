<?php

declare(strict_types=1);

namespace App\Notification\Subscription\Query;

use App\Notification\Subscription\Struct\Subscription;

interface SubscriptionByEventQuery
{
    /**
     * @return Subscription[]
     */
    public function fetch(string $eventType): array;
}
