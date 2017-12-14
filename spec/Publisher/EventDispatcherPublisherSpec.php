<?php

namespace spec\Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Publisher;

use spec\Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\AbstractObjectBehaviour;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Publisher\Event\EventToBeDispatched;
use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Publisher\Event\EventToBeDispatchedFactory;
use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Publisher\EventDispatcherPublisher;

class EventDispatcherPublisherSpec extends AbstractObjectBehaviour
{
    function it_is_initializable()
    {
        $this->shouldHaveType(EventDispatcherPublisher::class);
    }

    function let(EventDispatcherInterface $eventDispatcher, EventToBeDispatchedFactory $eventToBeDispatchedFactory)
    {
        $this->beConstructedWith($eventDispatcher, $eventToBeDispatchedFactory);

    }

    function it_dispatches_event_from_message(EventDispatcherInterface $eventDispatcher, EventToBeDispatchedFactory $eventToBeDispatchedFactory)
    {
        $message = $this->createMessage();

        $eventToBeDispatchedFactory->create($message)->willReturn(
            $eventToBeDispatched = new EventToBeDispatched(
                $eventName = $this->randomString(),
                $event = $this->createEvent()
            )
        );

        $eventDispatcher->dispatch($eventName, $event)->shouldBeCalled();

        $this->publish($message);
    }
}
