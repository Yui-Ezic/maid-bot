<?php

declare(strict_types=1);

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

$app->addErrorMiddleware(false, true, true);

$app->get('/', function (ServerRequestInterface $request, ResponseInterface $response) {
    $response->getBody()->write('{}');
    return $response->withHeader('Content-Type', 'application/json');
});

$app->run();
