<?php

namespace Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Publisher\Event\Exception;

use Webit\MessageBus\Message;

class CannotCreateEventFromMessageException extends AbstractEventFromMessageException
{
    protected static function exceptionMessage(Message $message): string
    {
        return sprintf('Could not create Event from Message of type "%s"', $message->type());
    }
}