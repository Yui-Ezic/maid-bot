<?php

declare(strict_types=1);

namespace App\Notification\Command\Subscribe;

use App\Notification\Event\Repository\EventRepository;
use App\Notification\Permission\PermissionChecker;
use App\Notification\Subscription\Repository\SubscriptionRepository;
use App\Notification\Subscription\Struct\Subscription;
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
        if ($this->isEventNotExist($command->eventId)) {
            throw new DomainException('Event is not exist.');
        }
        $subscription = $this->createSubscription($command);
        if ($this->isNotAllowed($subscription)) {
            throw new DomainException('Permission denied.');
        }
        $this->persist($subscription);
    }

    private function isEventNotExist(string $eventId): bool
    {
        return !$this->events->has($eventId);
    }

    private function createSubscription(Command $command): Subscription
    {
        return new Subscription($command->subscriberId, $command->eventId);
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
