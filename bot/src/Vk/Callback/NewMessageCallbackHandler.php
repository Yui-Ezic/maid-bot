<?php

declare(strict_types=1);

namespace App\Vk\Callback;

use App\Platform\Event\NewMessage;
use App\Platform\Event\Struct\Chat;
use App\Platform\Event\Struct\Message;
use App\Platform\Event\Struct\User;
use App\Vk\Callback\Exception\InvalidCallbackSchema;
use JsonSchema\Constraints\Constraint;
use JsonSchema\Validator;
use Psr\EventDispatcher\EventDispatcherInterface;

class NewMessageCallbackHandler extends AbstractHandler
{
    public function __construct(
        private EventDispatcherInterface $dispatcher,
        private Validator $validator
    ) {
    }

    public function handle(array $callback): ?string
    {
        $this->validate($callback);
        $this->createAndDispatchEvent($callback);
        return null;
    }

    /**
     * @psalm-assert array{
     *  object:array{
     *    message:array{
     *        from_id:int,
     *        peer_id:int,
     *        text:string
     *    }
     *  }
     * } $callback
     */
    protected function validate(array $callback): void
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
        $this->validator->validate($callback, $schema, Constraint::CHECK_MODE_TYPE_CAST);
        if (!$this->validator->isValid()) {
            throw new InvalidCallbackSchema('validation failed.');
        }
    }

    /**
     * @psalm-param array{
     *  object:array{
     *    message:array{
     *        from_id:int,
     *        peer_id:int,
     *        text:string
     *    }
     *  }
     * } $callback
     */
    private function createAndDispatchEvent(array $callback): void
    {
        $event = $this->createEvent($callback);
        $this->dispatcher->dispatch($event);
    }

    /**
     * @psalm-param array{
     *  object:array{
     *    message:array{
     *        from_id:int,
     *        peer_id:int,
     *        text:string
     *    }
     *  }
     * } $callback
     */
    private function createEvent(array $callback): NewMessage
    {
        $user = new User($callback['object']['message']['from_id']);
        $chat = new Chat((string)$callback['object']['message']['peer_id']);
        return new NewMessage(new Message($user, $chat, $callback['object']['message']['text']));
    }
}
