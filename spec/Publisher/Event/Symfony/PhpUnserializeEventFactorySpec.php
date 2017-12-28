<?php

namespace spec\Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Publisher\Event\Symfony;

use spec\Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\AbstractObjectBehaviour;
use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Publisher\Event\Symfony\Exception\DeserializationFailedException;
use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Publisher\Event\Symfony\PhpUnserializeEventFactory;

class PhpUnserializeEventFactorySpec extends AbstractObjectBehaviour
{
    function it_is_initializable()
    {
        $this->shouldHaveType(PhpUnserializeEventFactory::class);
    }

    function it_creates_event_using_php_unserialize_method()
    {
        $message = $this->createMessage(null, serialize($event = $this->createEvent()));

        $this->create($message)->shouldBeLike($event);
    }

    function it_throws_exception_when_unserialization_fails()
    {
        $message = $this->createMessage(null, substr(serialize(new \stdClass()), 0, 8));
        $this->shouldThrow(DeserializationFailedException::class)->duringCreate($message);
    }
}
