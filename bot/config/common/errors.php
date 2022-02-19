<?php

declare(strict_types=1);

use App\ErrorHandler\LogErrorHandler;
use App\ErrorHandler\SentryDecorator;
use App\Sentry;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Log\LoggerInterface;
use Slim\Interfaces\CallableResolverInterface;
use Slim\Interfaces\ErrorHandlerInterface;
use Slim\Middleware\ErrorMiddleware;
use function App\env;

return [
    ErrorMiddleware::class => static function (ContainerInterface $container): ErrorMiddleware {
        $callableResolver = $container->get(CallableResolverInterface::class);
        $responseFactory = $container->get(ResponseFactoryInterface::class);
        /**
         * @psalm-suppress MixedArrayAccess
         * @var array{display_details:bool} $config
         */
        $config = $container->get('config')['errors'];

        $middleware = new ErrorMiddleware(
            $callableResolver,
            $responseFactory,
            $config['display_details'],
            true,
            true
        );

        $middleware->setDefaultErrorHandler($container->get(LogErrorHandler::class));

        return $middleware;
    },
    ErrorHandlerInterface::class => static fn (ContainerInterface $container): ErrorHandlerInterface => new SentryDecorator(
        $container->get(LogErrorHandler::class),
        $container->get(Sentry::class)
    ),
    LogErrorHandler::class => static fn (ContainerInterface $container): LogErrorHandler => new LogErrorHandler(
        $container->get(CallableResolverInterface::class),
        $container->get(ResponseFactoryInterface::class),
        $container->get(LoggerInterface::class)
    ),

    'config' => [
        'errors' => [
            'display_details' => (bool)env('APP_DEBUG', '0'),
        ],
    ],
];
