<?php

namespace Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Listener\Message;

use Symfony\Component\EventDispatcher\Event;
use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Listener\Message\Content\EventSerialiser;
use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Listener\Message\Exception\CannotCreateMessageFromEventException;
use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Listener\Message\Type\EventNameMessageTypeResolver;
use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Listener\Message\Type\MessageTypeResolver;
use Webit\MessageBus\Message;

final class GenericMessageFromEventFactory implements MessageFromEventFactory
{
    /** @var EventSerialiser */
    private $eventSerialiser;

    /** @var MessageTypeResolver */
    private $messageTypeResolver;

    public function __construct(EventSerialiser $eventSerialiser, MessageTypeResolver $messageTypeResolver = null)
    {
        $this->eventSerialiser = $eventSerialiser;
        $this->messageTypeResolver = $messageTypeResolver ?: new EventNameMessageTypeResolver();
    }

    public function create(string $eventName, Event $event): Message
    {
        try {
            return new Message(
                $this->messageTypeResolver->resolve($eventName, $event),
                $this->eventSerialiser->serialise($eventName, $event)
            );
        } catch (\Exception $e) {
            throw CannotCreateMessageFromEventException::fromEvent($eventName, $event);
        }
    }
}
