<?php

namespace Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Listener\Message\Exception;

use Symfony\Component\EventDispatcher\Event;

class UnsupportedEventException extends AbstractMessageFromEventException
{
    protected static function exceptionMessage(string $eventName, Event $event): string
    {
        return sprintf('Event "%s" is not supported by this Message Factory', $eventName);
    }
}