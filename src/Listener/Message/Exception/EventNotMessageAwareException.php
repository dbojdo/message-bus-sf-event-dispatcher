<?php

namespace Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Listener\Message\Exception;

use Symfony\Component\EventDispatcher\Event;

class EventNotMessageAwareException extends AbstractMessageFromEventException
{
    protected static function exceptionMessage(string $eventName, Event $event): string
    {
        return sprintf(
            'Event of name "%s" must be instance of "Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Listener\Message\MessageAwareEvent" but "%s" given',
            $eventName,
            get_class($event)
        );
    }
}