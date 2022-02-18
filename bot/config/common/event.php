<?php

declare(strict_types=1);

use App\Bot\Hello\Listener\NewMessageListener;
use App\Platform\Event\NewMessage;
use League\Event\EventDispatcher;
use League\Event\PrioritizedListenerRegistry;
use Psr\Container\ContainerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\EventDispatcher\ListenerProviderInterface;

return [
    EventDispatcherInterface::class => static fn (ContainerInterface $container): EventDispatcherInterface => $container->get(EventDispatcher::class),
    EventDispatcher::class => static fn (ContainerInterface $container): EventDispatcher => new EventDispatcher($container->get(ListenerProviderInterface::class)),
    ListenerProviderInterface::class => static function (ContainerInterface $container): ListenerProviderInterface {
        $registry = new PrioritizedListenerRegistry();
        $registry->subscribeTo(NewMessage::class, $container->get(NewMessageListener::class));
        return $registry;
    },
];
