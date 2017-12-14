<?php

namespace spec\Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Listener\Message;

use spec\Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\AbstractObjectBehaviour;
use Symfony\Component\EventDispatcher\Event;
use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Listener\Message\Exception\EventNotMessageAwareException;
use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Listener\Message\FromMessageAwareEventMessageFromEventFactory;
use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Listener\Message\MessageAwareEvent;
use Webit\MessageBus\Message;

class FromMessageAwareEventMessageFromEventFactorySpec extends AbstractObjectBehaviour
{
    function it_is_initializable()
    {
        $this->shouldHaveType(FromMessageAwareEventMessageFromEventFactory::class);
    }

    function it_creates_message_from_message_aware_event(MessageAwareEventStub $event)
    {
        $eventName = $this->randomString();
        $event->createMessage($eventName)->willReturn($message = $this->createMessage());

        $this->create($eventName, $event)->shouldBe($message);
    }

    function it_throws_exception_if_non_message_aware_event_passed()
    {
        $this->shouldThrow(EventNotMessageAwareException::class)
            ->duringCreate($this->randomString(), $this->createEvent());
    }
}

class MessageAwareEventStub extends Event implements MessageAwareEvent
{
    public function createMessage(string $eventName): Message
    {
    }
}