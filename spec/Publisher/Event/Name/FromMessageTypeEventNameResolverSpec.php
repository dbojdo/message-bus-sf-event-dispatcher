<?php

namespace spec\Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Publisher\Event\Name;

use spec\Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\AbstractObjectBehaviour;
use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Publisher\Event\Name\FromMessageTypeEventNameResolver;

class FromMessageTypeEventNameResolverSpec extends AbstractObjectBehaviour
{
    function it_is_initializable()
    {
        $this->shouldHaveType(FromMessageTypeEventNameResolver::class);
    }

    function it_returns_message_type_as_event_name()
    {
        $message = $this->createMessage();
        $this->resolve($message)->shouldBe($message->type());
    }
}
