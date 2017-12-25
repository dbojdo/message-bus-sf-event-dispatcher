<?php

namespace Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Listener\Message;

use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Listener\Message\Content\EventSerialiser;
use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Listener\Message\Exception\CannotCreateMessageFromEventException;
use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Listener\Message\Type\EventNameMessageTypeResolver;
use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Listener\Message\Type\MessageTypeResolver;
use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\MessageBusEvent;
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

    public function create(MessageBusEvent $event): Message
    {
        try {
            return new Message(
                $this->messageTypeResolver->resolve($event),
                $this->eventSerialiser->serialise($event)
            );
        } catch (\Exception $e) {
            throw CannotCreateMessageFromEventException::fromEvent($event,0, $e);
        }
    }
}
