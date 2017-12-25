<?php

namespace Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Listener\Message\Exception;

use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\MessageBusEvent;

class EventNotMessageAwareException extends AbstractMessageFromEventException
{
    protected static function exceptionMessage(MessageBusEvent $event): string
    {
        return sprintf(
            'Event of name "%s" must be instance of "Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Listener\Message\MessageAwareEvent" but "%s" given',
            $event->name(),
            get_class($event->event())
        );
    }
}