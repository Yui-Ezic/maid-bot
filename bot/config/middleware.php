<?php

declare(strict_types=1);

use Slim\Middleware\ErrorMiddleware;

return static function (Slim\App $app): void {
    $app->add(ErrorMiddleware::class);
    $app->addBodyParsingMiddleware();
};
