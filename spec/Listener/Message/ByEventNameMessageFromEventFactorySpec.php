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
        MessageFromEventFactory $factory2,
        Event $event
    ){
        $factories = [
            $eventName1 = $this->randomString() => $factory1,
            $eventName2 = $this->randomString() => $factory2
        ];
        $this->beConstructedWith($factories);

        $factory2->create($eventName2, $event)->willReturn($message = $this->createMessage());
        $factory1->create(Argument::any(), Argument::any())->shouldNotBeCalled();
        $this->create($eventName2, $event)->shouldBe($message);
    }

    function it_throws_exception_if_no_matching_factory(
        MessageFromEventFactory $factory1,
        MessageFromEventFactory $factory2,
        Event $event
    ){
        $factories = [
            $eventName1 = $this->randomString() => $factory1,
            $eventName2 = $this->randomString() => $factory2
        ];
        $this->beConstructedWith($factories);

        $factory1->create(Argument::any(), Argument::any())->shouldNotBeCalled();
        $factory2->create(Argument::any(), Argument::any())->shouldNotBeCalled();

        $this->shouldThrow(UnsupportedEventException::class)->duringCreate($this->randomString(), $event);
    }
}
