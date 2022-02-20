<?php

declare(strict_types=1);

namespace App\Http\Action\Vk;

use App\Http\Response\PlainTextResponse;
use App\Sentry;
use App\Vk\Callback\CallbackHandler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Throwable;

class WebhookHandler implements RequestHandlerInterface
{
    public function __construct(
        private CallbackHandler $callbackHandler,
        private Sentry $sentry
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        /** @var array|null $callback */
        $callback = $request->getParsedBody();
        if ($callback) {
            try {
                $result = $this->callbackHandler->handle($callback);
            } catch (Throwable $e) {
                $this->sentry->capture($e);
                $result = null;
            }
        }
        return isset($result) && \is_string($result) ? new PlainTextResponse($result) : new PlainTextResponse('Ok');
    }
}
