<?php

declare(strict_types=1);

namespace App\Vk\Callback;

use App\Platform\Event\NewMessage;
use App\Platform\Event\Struct\Chat;
use App\Platform\Event\Struct\Message;
use App\Platform\Event\Struct\User;
use App\Vk\Callback\Exception\InvalidCallbackSchema;
use App\Vk\Callback\Struct\NewMessage\Callback;
use JsonSchema\Validator;
use Psr\EventDispatcher\EventDispatcherInterface;

class NewMessageCallbackHandler extends AbstractHandler
{
    public function __construct(
        private EventDispatcherInterface $dispatcher,
        private Validator $validator
    ) {
    }

    public function handle(object $callback): ?string
    {
        $this->validate($callback);
        $this->createAndDispatchEvent($this->deserialize($callback));
        return null;
    }

    protected function validate(object $callback): void
    {
        parent::validate($callback);
        $schema = [
            'type' => 'object',
            'required' => ['object'],
            'properties' => [
                'object' => [
                    'type' => 'object',
                    'required' => ['message'],
                    'properties' => [
                        'message' => [
                            'type' => 'object',
                            'required' => ['from_id', 'peer_id', 'text'],
                            'properties' => [
                                'from_id' => ['type' => 'integer'],
                                'peer_id' => ['type' => 'integer'],
                                'text' => ['type' => 'string'],
                            ],
                        ],
                    ],
                ],
            ],
        ];
        $this->validator->validate($callback, $schema);
        if (!$this->validator->isValid()) {
            throw new InvalidCallbackSchema('validation failed.');
        }
    }

    private function deserialize(object $callback): Callback
    {
        return Callback::fromRaw($callback);
    }

    private function createAndDispatchEvent(Callback $callback): void
    {
        $event = $this->createEvent($callback);
        $this->dispatcher->dispatch($event);
    }

    private function createEvent(Callback $callback): NewMessage
    {
        $user = new User($callback->getObject()->getMessage()->getFromId());
        $chat = new Chat((string)$callback->getObject()->getMessage()->getPeerId());
        return new NewMessage(new Message($user, $chat, $callback->getObject()->getMessage()->getText()));
    }
}
