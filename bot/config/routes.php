<?php

declare(strict_types=1);

use App\Http;
use Slim\App;

return static function (App $app): void {
    $app->get('/', Http\Action\HomeAction::class);
    $app->post('/vk/webhook', Http\Action\Vk\WebhookHandler::class);
};
