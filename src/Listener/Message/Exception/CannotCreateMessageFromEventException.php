<?php

namespace Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Listener\Message\Exception;

use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\MessageBusEvent;

class CannotCreateMessageFromEventException extends AbstractMessageFromEventException
{
    protected static function exceptionMessage(MessageBusEvent $event): string
    {
        return sprintf(
            'Could not create Message from Event of name "%s" and class "%s"',
            $event->name(),
            get_class($event->event())
        );
    }
}
