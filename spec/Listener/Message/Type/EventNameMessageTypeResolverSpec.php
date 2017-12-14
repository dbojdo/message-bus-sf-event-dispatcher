<?php

namespace spec\Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Listener\Message\Type;

use spec\Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\AbstractObjectBehaviour;
use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Listener\Message\Type\EventNameMessageTypeResolver;

class EventNameMessageTypeResolverSpec extends AbstractObjectBehaviour
{
    function it_is_initializable()
    {
        $this->shouldHaveType(EventNameMessageTypeResolver::class);
    }

    function it_returns_event_name_as_message_type()
    {
        $this->resolve($eventName = $this->randomString(), $this->createEvent())->shouldBe($eventName);
    }
}
