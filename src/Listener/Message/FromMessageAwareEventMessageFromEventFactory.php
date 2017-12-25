<?php

namespace Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Listener\Message;

use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Listener\Message\Exception\EventNotMessageAwareException;
use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\MessageBusEvent;
use Webit\MessageBus\Message;

final class FromMessageAwareEventMessageFromEventFactory implements MessageFromEventFactory
{
    public function create(MessageBusEvent $event): Message
    {
        $sfEvent = $event->event();
        if ($sfEvent instanceof MessageAwareEvent) {
            return $sfEvent->createMessage($event->name());
        }

        throw EventNotMessageAwareException::fromEvent($event);
    }
}