<?php

namespace App\Platform\Interactor;

interface MessageSender
{
    public function send(Message $message): void;
}