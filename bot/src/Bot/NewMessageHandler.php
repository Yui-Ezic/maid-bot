<?php

namespace App\Bot;

use App\Platform\Event\NewMessage;
use App\Profanity\Command\CheckMessage\Handler as ProfanityCheckMessageHandler;
use App\Profanity\Command\CheckMessage\Command as ProfanityCheckMessageCommand;

class NewMessageHandler
{
    private ProfanityCheckMessageHandler $profanityCheckMessageHandler;

    public function __construct(ProfanityCheckMessageHandler $profanityCheckMessageHandler)
    {
        $this->profanityCheckMessageHandler = $profanityCheckMessageHandler;
    }

    public function handle(NewMessage $event): void
    {
        $this->profanityCheckMessageHandler->handle(new ProfanityCheckMessageCommand($event->getMessage()->getText()));
    }
}