<?php

namespace spec\Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Listener\Message;

use Prophecy\Argument;
use spec\Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\AbstractObjectBehaviour;
use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Listener\Message\Exception\UnsupportedEventException;
use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Listener\Message\FallingBackMessageFromEventFactory;
use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Listener\Message\MessageFromEventFactory;

class FallingBackMessageFromEventFactorySpec extends AbstractObjectBehaviour
{
    function it_is_initializable()
    {
        $this->shouldHaveType(FallingBackMessageFromEventFactory::class);
    }

    function let(MessageFromEventFactory $mainFactory, MessageFromEventFactory $fallbackFactory)
    {
        $this->beConstructedWith($mainFactory, $fallbackFactory);
    }

    function it_uses_main_factory_by_default(
        MessageFromEventFactory $mainFactory,
        MessageFromEventFactory $fallbackFactory
    ) {
        $mainFactory
            ->create($eventName = $this->randomString(), $event = $this->createEvent())
            ->willReturn($message = $this->createMessage());

        $fallbackFactory->create(Argument::any(), Argument::any())->shouldNotBeCalled();

        $this->create($eventName, $event)->shouldBe($message);
    }

    function it_uses_fallback_factory_when_main_fails(
        MessageFromEventFactory $mainFactory,
        MessageFromEventFactory $fallbackFactory
    ) {
        $mainFactory
            ->create($eventName = $this->randomString(), $event = $this->createEvent())
            ->willThrow(UnsupportedEventException::class);

        $fallbackFactory
            ->create($eventName, $event)
            ->willReturn($message = $this->createMessage());

        $this->create($eventName, $event)->shouldBe($message);
    }
}
