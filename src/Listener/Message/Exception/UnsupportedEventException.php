<?php

namespace Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Listener\Message\Exception;

use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\MessageBusEvent;

class UnsupportedEventException extends AbstractMessageFromEventException
{
    protected static function exceptionMessage(MessageBusEvent $event): string
    {
        return sprintf('Event "%s" is not supported by this Message Factory', $event->name());
    }
}