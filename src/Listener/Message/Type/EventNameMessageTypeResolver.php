<?php

namespace Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Listener\Message\Type;

use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\MessageBusEvent;

final class EventNameMessageTypeResolver implements MessageTypeResolver
{
    public function resolve(MessageBusEvent $event): string
    {
        return $event->name();
    }
}
