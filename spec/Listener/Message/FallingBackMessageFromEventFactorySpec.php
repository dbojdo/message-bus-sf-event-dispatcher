<?php

namespace spec\Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Listener\Message;

use Prophecy\Argument;
use spec\Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\AbstractObjectBehaviour;
use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Listener\Message\Exception\UnsupportedEventException;
use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Listener\Message\FallingBackMessageFromEventFactory;
use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Listener\Message\MessageFromEventFactory;
use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\MessageBusEvent;

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
        $messageBusEvent = $this->createMessageBusEvent();

        $mainFactory
            ->create($messageBusEvent)
            ->willReturn($message = $this->createMessage());

        $fallbackFactory->create($messageBusEvent)->shouldNotBeCalled();

        $this->create($messageBusEvent)->shouldBe($message);
    }

    function it_uses_fallback_factory_when_main_fails(
        MessageFromEventFactory $mainFactory,
        MessageFromEventFactory $fallbackFactory
    ) {
        $messageBusEvent = $this->createMessageBusEvent();

        $mainFactory
            ->create($messageBusEvent)
            ->willThrow(UnsupportedEventException::class);

        $fallbackFactory
            ->create($messageBusEvent)
            ->willReturn($message = $this->createMessage());

        $this->create($messageBusEvent)->shouldBe($message);
    }
}
