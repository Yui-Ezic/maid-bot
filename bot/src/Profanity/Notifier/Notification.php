<?php

declare(strict_types=1);

namespace App\Profanity\Notifier;

use App\Profanity\Detector\Message;
use App\Profanity\Detector\ProfanityCollection;

class Notification
{
    public function __construct(
        private Message $message,
        private ProfanityCollection $profanities
    )
    {}

    public function getMessage(): Message
    {
        return $this->message;
    }

    public function getProfanities(): ProfanityCollection
    {
        return $this->profanities;
    }
}