<?php

declare(strict_types=1);

namespace App\Http\Action\Botman;

use App\Http\Response\JsonResponse;
use BotMan\BotMan\BotMan;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use stdClass;

class HandleAction implements RequestHandlerInterface
{
    public function __construct(
        private BotMan $botMan
    ) {}

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        // Start listening
        $this->botMan->listen();

        // Return empty response
        return new JsonResponse(new StdClass());
    }
}