<?php

declare(strict_types=1);

namespace App\Vk\Callback\Struct\NewMessage;

class Callback
{
    public function __construct(private ObjectStruct $object)
    {
    }

    public function getObject(): ObjectStruct
    {
        return $this->object;
    }

    /**
     * @psalm-suppress MixedPropertyFetch
     * @psalm-suppress MixedAssignment
     * @psalm-suppress MixedArgument
     */
    public static function fromRaw(object $callback): self
    {
        $message = $callback->object->message;
        return new self(new ObjectStruct(new Message($message->from_id, $message->peer_id, $message->text)));
    }
}
