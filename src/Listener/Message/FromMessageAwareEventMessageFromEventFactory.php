<?php

namespace Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Listener\Message;

use Symfony\Component\EventDispatcher\Event;
use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Listener\Message\Exception\EventNotMessageAwareException;
use Webit\MessageBus\Message;

final class FromMessageAwareEventMessageFromEventFactory implements MessageFromEventFactory
{
    public function create(string $eventName, Event $event): Message
    {
        if ($event instanceof MessageAwareEvent) {
            return $event->createMessage($eventName);
        }

        throw EventNotMessageAwareException::fromEvent($eventName, $event);
    }
}