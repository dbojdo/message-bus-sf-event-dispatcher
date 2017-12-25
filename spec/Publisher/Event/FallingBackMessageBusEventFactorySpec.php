<?php

namespace spec\Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Publisher\Event;

use spec\Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\AbstractObjectBehaviour;
use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Publisher\Event\MessageBusEventFactory;
use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Publisher\Event\Exception\CannotCreateEventFromMessageException;
use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Publisher\Event\FallingBackMessageBusEventFactory;
use Prophecy\Argument;

class FallingBackMessageBusEventFactorySpec extends AbstractObjectBehaviour
{
    function it_is_initializable()
    {
        $this->shouldHaveType(FallingBackMessageBusEventFactory::class);
    }

    function let(MessageBusEventFactory $mainFactory, MessageBusEventFactory $fallbackFactory)
    {
        $this->beConstructedWith($mainFactory, $fallbackFactory);
    }

    function it_creates_event_with_main_factory(
        MessageBusEventFactory $mainFactory,
        MessageBusEventFactory $fallbackFactory
    ) {
        $mainFactory->create($message = $this->createMessage())->willReturn($event = $this->createMessageBusEvent());
        $fallbackFactory->create(Argument::any())->shouldNotBeCalled();

        $this->create($message)->shouldBe($event);
    }

    function it_uses_fallback_factory_on_main_factory_exception(
        MessageBusEventFactory $mainFactory,
        MessageBusEventFactory $fallbackFactory
    ) {
        $mainFactory->create($message = $this->createMessage())->willThrow(CannotCreateEventFromMessageException::class);
        $fallbackFactory->create($message)->willReturn($event = $this->createMessageBusEvent());

        $this->create($message)->shouldBe($event);
    }
}
