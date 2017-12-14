<?php

namespace Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Publisher\Event\Exception;

use Webit\MessageBus\Message;

class UnsupportedMessageTypeException extends AbstractEventFromMessageException
{
    protected static function exceptionMessage(Message $message): string
    {
        return sprintf('Message of type "%s" is not supported by Event Dispatcher', $message->type());
    }
}