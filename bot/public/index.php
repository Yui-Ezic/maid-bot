<?php

declare(strict_types=1);

use App\Http\Action\HomeAction;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$builder = new \DI\ContainerBuilder();

$container = $builder->build();

$app = AppFactory::createFromContainer($container);

$app->addErrorMiddleware(true, true, true);

$app->addErrorMiddleware(false, true, true);

$app->get('/', HomeAction::class);

$app->run();
