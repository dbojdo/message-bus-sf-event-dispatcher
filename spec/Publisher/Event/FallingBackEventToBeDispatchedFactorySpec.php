<?php

namespace spec\Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Publisher\Event;

use spec\Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\AbstractObjectBehaviour;
use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Publisher\Event\EventToBeDispatchedFactory;
use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Publisher\Event\Exception\CannotCreateEventFromMessageException;
use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Publisher\Event\FallingBackEventToBeDispatchedFactory;
use Prophecy\Argument;

class FallingBackEventToBeDispatchedFactorySpec extends AbstractObjectBehaviour
{
    function it_is_initializable()
    {
        $this->shouldHaveType(FallingBackEventToBeDispatchedFactory::class);
    }

    function let(EventToBeDispatchedFactory $mainFactory, EventToBeDispatchedFactory $fallbackFactory)
    {
        $this->beConstructedWith($mainFactory, $fallbackFactory);
    }

    function it_creates_event_with_main_factory(
        EventToBeDispatchedFactory $mainFactory,
        EventToBeDispatchedFactory $fallbackFactory
    ) {
        $mainFactory->create($message = $this->createMessage())->willReturn($event = $this->createEventToBeDispatched());
        $fallbackFactory->create(Argument::any())->shouldNotBeCalled();

        $this->create($message)->shouldBe($event);
    }

    function it_uses_fallback_factory_on_main_factory_exception(
        EventToBeDispatchedFactory $mainFactory,
        EventToBeDispatchedFactory $fallbackFactory
    ) {
        $mainFactory->create($message = $this->createMessage())->willThrow(CannotCreateEventFromMessageException::class);
        $fallbackFactory->create($message)->willReturn($event = $this->createEventToBeDispatched());

        $this->create($message)->shouldBe($event);
    }
}
