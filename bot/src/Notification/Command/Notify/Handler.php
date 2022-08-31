<?php

declare(strict_types=1);

namespace App\Notification\Command\Notify;

use App\Notification\Query\FindSubscriptionsByEventId\Fetcher;
use App\Notification\Query\FindSubscriptionsByEventId\Query;
use App\Notification\Subscription\Struct\Subscription;
use App\Platform\Interactor\Message;
use App\Platform\Interactor\MessageSender;
use Psr\Log\LoggerInterface;
use Throwable;

class Handler
{
    public function __construct(
        private Fetcher $subscriptionQuery,
        private MessageSender $messageSender,
        private LoggerInterface $logger
    ) {
    }

    public function handler(Command $command): void
    {
        $subscriptions = $this->getSubscriptionsByEvent($command->eventType);
        foreach ($subscriptions as $subscription) {
            $this->notify($subscription, $command->message);
        }
    }

    /**
     * @return Subscription[]
     */
    private function getSubscriptionsByEvent(string $eventType): array
    {
        return $this->subscriptionQuery->fetch(new Query($eventType));
    }

    private function notify(Subscription $subscription, Message $message): void
    {
        try {
            $this->tryNotify($subscription, $message);
        } catch (Throwable $exception) {
            $this->logger->error('Subscriber notification failed.', [
                'exception' => $exception,
                'subscription' => $subscription,
                'message' => $message,
            ]);
        }
    }

    private function tryNotify(Subscription $subscription, Message $message): void
    {
        $this->messageSender->send($subscription->getSubscriberId(), $message);
    }
}
