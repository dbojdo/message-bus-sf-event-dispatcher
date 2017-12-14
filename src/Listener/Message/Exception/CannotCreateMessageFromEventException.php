<?php

namespace Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Listener\Message\Exception;

use Symfony\Component\EventDispatcher\Event;

class CannotCreateMessageFromEventException extends AbstractMessageFromEventException
{
    protected static function exceptionMessage(string $eventName, Event $event): string
    {
        return sprintf(
            'Could not create Message from Event of name "%s" and class "%s"',
            $eventName,
            get_class($event)
        );
    }
}
