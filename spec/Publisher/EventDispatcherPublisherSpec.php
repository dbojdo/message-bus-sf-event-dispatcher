<?php

namespace spec\Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Publisher;

use spec\Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\AbstractObjectBehaviour;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\MessageBusEvent;
use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Publisher\Event\EventToBeDispatched;
use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Publisher\Event\MessageBusEventFactory;
use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Publisher\EventDispatcherPublisher;

class EventDispatcherPublisherSpec extends AbstractObjectBehaviour
{
    function it_is_initializable()
    {
        $this->shouldHaveType(EventDispatcherPublisher::class);
    }

    function let(EventDispatcherInterface $eventDispatcher, MessageBusEventFactory $messageBusEventFactory)
    {
        $this->beConstructedWith($eventDispatcher, $messageBusEventFactory);

    }

    function it_dispatches_event_from_message(EventDispatcherInterface $eventDispatcher, MessageBusEventFactory $messageBusEventFactory)
    {
        $message = $this->createMessage();

        $messageBusEventFactory->create($message)->willReturn(
            $messageBusEvent = $this->createMessageBusEvent()
        );

        $eventDispatcher->dispatch($messageBusEvent->name(), $messageBusEvent->event())->shouldBeCalled();

        $this->publish($message);
    }
}
