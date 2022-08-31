<?php

declare(strict_types=1);

namespace App\Notification\Query\FindSubscriptionsByEventId;

interface Fetcher
{
    /**
     * @return Subscription[]
     */
    public function fetch(Query $query): array;
}
