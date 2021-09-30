<?php

declare(strict_types=1);

namespace App\Profanity\Command\CheckMessage;

use App\Profanity\Detector\Message;
use App\Profanity\Detector\ProfanityDetector;
use App\Profanity\Notifier\Notification;
use App\Profanity\Notifier\Notifier;

class Handler
{
    public function __construct(
        private ProfanityDetector $profanityDetector,
        private Notifier $notifier
    )
    {}

    public function handle(Command $command)
    {
        $message = new Message($command->text);
        $profanities = $this->profanityDetector->detect($message);
        if ($profanities->notEmpty()) {
            $this->notifier->notify(new Notification($message, $profanities));
        }
    }
}