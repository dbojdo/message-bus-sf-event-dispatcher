<?php

namespace spec\Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Listener;

use spec\Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\AbstractObjectBehaviour;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Webit\MessageBus\Consumer;
use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Listener\EventConsumingListener;
use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Listener\Message\MessageFromEventFactory;
use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\MessageBusEvent;

class EventConsumingListenerSpec extends AbstractObjectBehaviour
{
    function it_is_initializable()
    {
        $this->shouldHaveType(EventConsumingListener::class);
    }

    function let(Consumer $consumer, MessageFromEventFactory $messageFromEvent)
    {
        $this->beConstructedWith($consumer, $messageFromEvent);
    }

    function it_consumes_event(
        Consumer $consumer,
        MessageFromEventFactory $messageFromEvent,
        EventDispatcherInterface $eventDispatcher
    ) {
        $eventName = $this->randomString();
        $event = $this->createEvent();

        $messageBusEvent = new MessageBusEvent($eventName, $event);

        $messageFromEvent->create($messageBusEvent)->willReturn($message = $this->createMessage());
        $consumer->consume($message)->shouldBeCalled();

        $this->onEvent($event, $eventName, $eventDispatcher);
    }
}
