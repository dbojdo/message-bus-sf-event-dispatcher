<?php

namespace spec\Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Listener\Message;

use spec\Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\AbstractObjectBehaviour;
use Symfony\Component\EventDispatcher\Event;
use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Listener\Message\ByEventNameMessageFromEventFactory;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Listener\Message\Exception\UnsupportedEventException;
use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Listener\Message\MessageFromEventFactory;

class ByEventNameMessageFromEventFactorySpec extends AbstractObjectBehaviour
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ByEventNameMessageFromEventFactory::class);
    }

    function let()
    {
        $this->beConstructedWith([]);
    }

    function it_uses_factory_by_event_name(
        MessageFromEventFactory $factory1,
        MessageFromEventFactory $factory2
    ){
        $factories = [
            $eventName1 = $this->randomString() => $factory1,
            $eventName2 = $this->randomString() => $factory2
        ];
        $this->beConstructedWith($factories);

        $messageBusEvent = $this->createMessageBusEvent($eventName2);

        $factory2->create($messageBusEvent)->willReturn($message = $this->createMessage());
        $factory1->create($messageBusEvent)->shouldNotBeCalled();
        $this->create($messageBusEvent)->shouldBe($message);
    }

    function it_throws_exception_if_no_matching_factory(
        MessageFromEventFactory $factory1,
        MessageFromEventFactory $factory2
    ){
        $factories = [
            $eventName1 = $this->randomString() => $factory1,
            $eventName2 = $this->randomString() => $factory2
        ];
        $this->beConstructedWith($factories);

        $messageBusEvent = $this->createMessageBusEvent($this->randomString());

        $factory1->create($messageBusEvent)->shouldNotBeCalled();
        $factory2->create($messageBusEvent)->shouldNotBeCalled();

        $this->shouldThrow(UnsupportedEventException::class)->duringCreate($messageBusEvent);
    }
}
