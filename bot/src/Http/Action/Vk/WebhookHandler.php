<?php

declare(strict_types=1);

namespace App\Http\Action\Vk;

use App\Http\Response\PlainTextResponse;
use App\Vk\Callback\CallbackHandler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class WebhookHandler implements RequestHandlerInterface
{
    private CallbackHandler $callbackHandler;

    public function __construct(CallbackHandler $callbackHandler)
    {
        $this->callbackHandler = $callbackHandler;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        /** @var array|null $callback */
        $callback = $request->getParsedBody();
        if ($callback) {
            $result = $this->callbackHandler->handle($callback);
        }
        return isset($result) && \is_string($result) ? new PlainTextResponse($result) : new PlainTextResponse('Ok');
    }
}
