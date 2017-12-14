<?php

namespace spec\Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Listener\Message;

use spec\Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\AbstractObjectBehaviour;
use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Listener\Message\Content\EventSerialiser;
use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Listener\Message\GenericMessageFromEventFactory;
use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Listener\Message\Type\MessageTypeResolver;
use Webit\MessageBus\Message;

class GenericMessageFromEventFactorySpec extends AbstractObjectBehaviour
{
    function it_is_initializable()
    {
        $this->shouldHaveType(GenericMessageFromEventFactory::class);
    }

    function let(EventSerialiser $eventSerialiser, MessageTypeResolver $messageTypeResolver)
    {
        $this->beConstructedWith($eventSerialiser, $messageTypeResolver);
    }

    function it_creates_message_from_event(EventSerialiser $eventSerialiser, MessageTypeResolver $messageTypeResolver)
    {
        $eventName = $this->randomString();
        $event = $this->createEvent();

        $messageTypeResolver->resolve($eventName, $event)->willReturn($messageType = $this->randomString());
        $eventSerialiser->serialise($eventName, $event)->willReturn($messageContent = $this->randomString());

        $this->create($eventName, $event)->shouldBeLike(new Message($messageType, $messageContent));
    }

    function it_uses_event_name_as_message_type_by_default(EventSerialiser $eventSerialiser)
    {
        $this->beConstructedWith($eventSerialiser);

        $eventName = $this->randomString();
        $event = $this->createEvent();
        $eventSerialiser->serialise($eventName, $event)->willReturn($messageContent = $this->randomString());

        $this->create($eventName, $event)->shouldBeLike(new Message($eventName, $messageContent));
    }
}
