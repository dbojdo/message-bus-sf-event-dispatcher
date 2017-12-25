<?php

namespace spec\Webit\MessageBus\Infrastructure\Symfony\EventDispatcher;

use PhpSpec\ObjectBehavior;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\GenericEvent;
use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\MessageBusEvent;
use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Publisher\Event\EventToBeDispatched;
use Webit\MessageBus\Message;
use Webit\Tests\Unit\RandomValuesTrait;

class AbstractObjectBehaviour extends ObjectBehavior
{
    use RandomValuesTrait;

    function createMessage(string $type = null, string $content = null): Message
    {
        return new Message(
            $type ?: $this->randomString(),
            $content ?: $this->randomString()
        );
    }

    function createEvent(): GenericEvent
    {
        return new GenericEvent($this->randomString());
    }

    function createMessageBusEvent(string $eventName = null, Event $event = null): MessageBusEvent
    {
        return new MessageBusEvent(
            $eventName ?: $this->randomString(),
            $event ?: $this->createEvent()
        );
    }
}
