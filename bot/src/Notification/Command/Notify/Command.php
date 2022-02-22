<?php

declare(strict_types=1);

namespace App\Notification\Command\Notify;

use App\Platform\Interactor\Message;

class Command
{
    public function __construct(
        public string $eventType,
        public Message $message
    ) {
    }
}
