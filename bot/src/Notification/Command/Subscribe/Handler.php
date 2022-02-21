<?php

declare(strict_types=1);

namespace App\Notification\Command\Subscribe;

use App\Notification\Permission\PermissionChecker;
use App\Notification\Repository\EventRepository;
use App\Notification\Repository\SubscriptionRepository;
use App\Notification\Struct\Subscription;
use DomainException;

class Handler
{
    public function __construct(
        private SubscriptionRepository $subscriptions,
        private PermissionChecker $permissionChecker,
        private EventRepository $events,
    ) {
    }

    public function handle(Command $command): void
    {
        if ($this->isEventNotExist($command->eventType)) {
            throw new DomainException('Event is not exist.');
        }
        $subscription = $this->createSubscription($command);
        if ($this->isNotAllowed($subscription)) {
            throw new DomainException('Permission denied.');
        }
        $this->persist($subscription);
    }

    private function isEventNotExist(string $eventType): bool
    {
        return !$this->events->has($eventType);
    }

    private function createSubscription(Command $command): Subscription
    {
        return new Subscription($command->subscriberId, $command->eventType);
    }

    private function isNotAllowed(Subscription $subscription): bool
    {
        return !$this->permissionChecker->isAllowed($subscription);
    }

    private function persist(Subscription $subscription): void
    {
        $this->subscriptions->persist($subscription);
    }
}
