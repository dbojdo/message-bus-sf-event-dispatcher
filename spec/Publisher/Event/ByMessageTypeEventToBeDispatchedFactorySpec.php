<?php

namespace spec\Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Publisher\Event;

use spec\Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\AbstractObjectBehaviour;
use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Publisher\Event\ByMessageTypeEventToBeDispatchedFactory;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Publisher\Event\EventToBeDispatchedFactory;
use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Publisher\Event\Exception\UnsupportedMessageTypeException;

class ByMessageTypeEventToBeDispatchedFactorySpec extends AbstractObjectBehaviour
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ByMessageTypeEventToBeDispatchedFactory::class);
    }

    function let()
    {
        $this->beConstructedWith([]);
    }

    function it_resolves_factory_by_message_type(
        EventToBeDispatchedFactory $factory1,
        EventToBeDispatchedFactory $factory2
    ) {
        $factories = [
            $type1 = $this->randomString() => $factory1,
            $type2 = $this->randomString() => $factory2
        ];

        $this->beConstructedWith($factories);

        $message = $this->createMessage($type2);
        $factory2->create($message)->willReturn($event = $this->createEventToBeDispatched());
        $factory1->create($message)->shouldNotBeCalled();

        $this->create($message)->shouldBe($event);
    }

    function it_throws_exception_if_no_factory_matches_the_type(EventToBeDispatchedFactory $factory1)
    {
        $factories = [
            $type1 = $this->randomString() => $factory1
        ];

        $this->beConstructedWith($factories);

        $message = $this->createMessage($this->randomString());
        $factory1->create($message)->shouldNotBeCalled();

        $this->shouldThrow(UnsupportedMessageTypeException::class)->during('create', [$message]);
    }
}
