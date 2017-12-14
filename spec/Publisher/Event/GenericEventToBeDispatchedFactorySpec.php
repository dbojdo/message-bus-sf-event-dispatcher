<?php

namespace spec\Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Publisher\Event;

use spec\Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\AbstractObjectBehaviour;
use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Publisher\Event\EventToBeDispatched;
use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Publisher\Event\GenericEventToBeDispatchedFactory;
use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Publisher\Event\Name\EventNameResolver;
use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Publisher\Event\Symfony\SymfonyEventFactory;

class GenericEventToBeDispatchedFactorySpec extends AbstractObjectBehaviour
{
    function it_is_initializable()
    {
        $this->shouldHaveType(GenericEventToBeDispatchedFactory::class);
    }

    function let(SymfonyEventFactory $factory, EventNameResolver $eventNameResolver)
    {
        $this->beConstructedWith($factory, $eventNameResolver);
    }

    function it_creates_event_from_message(SymfonyEventFactory $factory, EventNameResolver $eventNameResolver)
    {
        $message = $this->createMessage();

        $eventNameResolver->resolve($message)->willReturn($eventName = $this->randomString());
        $factory->create($message)->willReturn($symfonyEvent = $this->createEvent());

        $this->create($message)->shouldBeLike(new EventToBeDispatched($eventName, $symfonyEvent));
    }

    function it_takes_event_name_from_message_type_if_name_resolver_not_set(
        SymfonyEventFactory $factory
    ) {
        $this->beConstructedWith($factory);

        $message = $this->createMessage();
        $factory->create($message)->willReturn($symfonyEvent = $this->createEvent());

        $this->create($message)->shouldBeLike(new EventToBeDispatched($message->type(), $symfonyEvent));
    }
}
