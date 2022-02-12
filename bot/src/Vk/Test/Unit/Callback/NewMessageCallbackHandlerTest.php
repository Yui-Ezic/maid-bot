<?php

declare(strict_types=1);

namespace App\Vk\Test\Unit\Callback;

use App\Vk\Callback\Exception\InvalidCallbackSchema;
use App\Vk\Callback\NewMessageCallbackHandler;
use JsonSchema\Validator;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\EventDispatcher\EventDispatcherInterface;

/**
 * @internal
 */
final class NewMessageCallbackHandlerTest extends TestCase
{
    /**
     * @psalm-var MockObject&EventDispatcherInterface|null
     */
    private ?MockObject $eventDispatcherMock;

    protected function setUp(): void
    {
        parent::setUp();
        $this->eventDispatcherMock = null;
    }

    public function testSuccess(): void
    {
        $callback = [
            'object' => [
                'message' => [
                    'from_id' => 1,
                    'peer_id' => 2,
                    'text' => 'Hello!',
                ],
            ],
        ];

        $result = $this->getNewMessageCallbackHandler()->handle($callback);

        self::assertNull($result);
    }

    /**
     * @psalm-return array<string,array<int,array>>
     */
    public function invalidCallbacks(): array
    {
        return [
            'Empty' => [[]],
            'Invalid object type' => [['object' => 'string']],
            'No message' => [['object' => []]],
            'Invalid message type' => [['object' => ['message' => 10]]],
            'Empty message' => [['object' => ['message' => []]]],
            'No from_id' => [
                [
                    'object' => [
                        'message' => [
                            'peer_id' => 2,
                            'text' => 'Hello!',
                        ],
                    ],
                ],
            ],
            'Invalid from_id type' => [
                [
                    'object' => [
                        'message' => [
                            'from_id' => 1.1,
                            'peer_id' => 2,
                            'text' => 'Hello!',
                        ],
                    ],
                ],
            ],
            'No peer_id' => [
                [
                    'object' => [
                        'message' => [
                            'from_id' => 1,
                            'text' => 'Hello!',
                        ],
                    ],
                ],
            ],
            'Invalid peer_id type' => [
                [
                    'object' => [
                        'message' => [
                            'from_id' => 1,
                            'peer_id' => 2.2,
                            'text' => 'Hello!',
                        ],
                    ],
                ],
            ],
            'No text' => [
                [
                    'object' => [
                        'message' => [
                            'from_id' => 1,
                            'peer_id' => 2,
                        ],
                    ],
                ],
            ],
            'Invalid text type' => [
                [
                    'object' => [
                        'message' => [
                            'from_id' => 1,
                            'peer_id' => 2,
                            'text' => [],
                        ],
                    ],
                ],
            ],
        ];
    }

    /**
     * @dataProvider invalidCallbacks
     */
    public function testValidation(array $callback): void
    {
        self::expectException(InvalidCallbackSchema::class);

        $this->getNewMessageCallbackHandler()->handle($callback);
    }

    private function getNewMessageCallbackHandler(): NewMessageCallbackHandler
    {
        return new NewMessageCallbackHandler($this->getEventDispatcherMock(), $this->getValidator());
    }

    /**
     * @psalm-return MockObject&EventDispatcherInterface
     */
    private function getEventDispatcherMock(): MockObject
    {
        if ($this->eventDispatcherMock === null) {
            $this->eventDispatcherMock = $this->createMock(EventDispatcherInterface::class);
        }
        return $this->eventDispatcherMock;
    }

    private function getValidator(): Validator
    {
        return new Validator();
    }
}
