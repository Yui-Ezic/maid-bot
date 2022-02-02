<?php

declare(strict_types=1);

namespace App\Http\Action\Vk;

use App\Http\Response\PlainTextResponse;
use App\Vk\Callback\CallbackHandler;
use DomainException;
use JsonException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use stdClass;

class WebhookHandler implements RequestHandlerInterface
{
    private CallbackHandler $callbackHandler;

    public function __construct(CallbackHandler $callbackHandler)
    {
        $this->callbackHandler = $callbackHandler;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $body = (string)$request->getBody();
        try {
            /** @var stdClass $callback */
            $callback = json_decode($body, false, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException) {
            throw new DomainException('Cannot decode body.');
        }
        $result = $this->callbackHandler->handle($callback);
        return $result !== null ? new PlainTextResponse($result) : new PlainTextResponse('Ok');
    }
}
