<?php

declare(strict_types=1);

namespace App\Notification\Query\FindSubscriptionsByEventType;

use App\Notification\Subscription\Struct\Subscription;

interface Fetcher
{
    /**
     * @return Subscription[]
     */
    public function fetch(Query $query): array;
}
