<?php

namespace spec\Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Publisher\Event\Symfony;

use spec\Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\AbstractObjectBehaviour;
use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Publisher\Event\Symfony\ByMessageTypeJMSSerializerTypeMap;
use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Publisher\Event\Symfony\JMSSerializerTypeMap;

class ByMessageTypeJMSSerializerTypeMapSpec extends AbstractObjectBehaviour
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ByMessageTypeJMSSerializerTypeMap::class);
        $this->shouldBeAnInstanceOf(JMSSerializerTypeMap::class);
    }

    function let()
    {
        $this->beConstructedWith([]);
    }

    function it_returns_message_type_if_not_mapped()
    {
        $message = $this->createMessage();
        $this->type($message)->shouldBe($message->type());
    }

    function it_returns_mapped_type_by_message_type()
    {
        $message = $this->createMessage();

        $this->beConstructedWith([
            $this->randomString() => $this->randomString(),
            $message->type() => $mappedType = $this->randomString()
        ]);

        $this->type($message)->shouldBe($mappedType);
    }
}
