<?php

namespace Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Listener\Message\Type;

use Symfony\Component\EventDispatcher\Event;

final class EventNameMessageTypeResolver implements MessageTypeResolver
{
    public function resolve(string $eventName, Event $event): string
    {
        return $eventName;
    }
}
