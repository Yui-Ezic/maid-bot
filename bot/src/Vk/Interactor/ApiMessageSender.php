<?php

declare(strict_types=1);

namespace App\Vk\Interactor;

use App\Platform\Interactor\Message;
use App\Platform\Interactor\MessageSender;
use VK\Client\VKApiClient;

class ApiMessageSender implements MessageSender
{
    public function __construct(
        private VKApiClient $api,
        private string $accessToken
    ) {
    }

    public function send(Message $message): void
    {
        $this->api->messages()->send($this->accessToken, [
            'peer_id' => (int)$message->getChatId(),
            'random_id' => random_int(0, getrandmax()),
            'message' => $message->getText(),
        ]);
    }
}
