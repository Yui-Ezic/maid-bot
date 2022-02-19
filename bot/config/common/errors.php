<?php

declare(strict_types=1);

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Slim\Interfaces\CallableResolverInterface;
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

        return new ErrorMiddleware(
            $callableResolver,
            $responseFactory,
            $config['display_details'],
            true,
            true
        );
    },

    'config' => [
        'errors' => [
            'display_details' => (bool)env('APP_DEBUG', '0'),
        ],
    ],
];
