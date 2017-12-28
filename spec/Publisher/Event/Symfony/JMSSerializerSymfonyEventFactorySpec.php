<?php

namespace spec\Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Publisher\Event\Symfony;

use JMS\Serializer\DeserializationContext;
use JMS\Serializer\SerializerInterface;
use spec\Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\AbstractObjectBehaviour;
use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Publisher\Event\Symfony\JMSSerializerSymfonyEventFactory;
use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Publisher\Event\Symfony\JMSSerializerTypeMap;
use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Publisher\Event\Symfony\SymfonyEventFactory;
use Webit\MessageBus\Message;

class JMSSerializerSymfonyEventFactorySpec extends AbstractObjectBehaviour
{
    function it_is_initializable()
    {
        $this->shouldHaveType(JMSSerializerSymfonyEventFactory::class);
        $this->shouldBeAnInstanceOf(SymfonyEventFactory::class);
    }

    function let(SerializerInterface $serializer, JMSSerializerTypeMap $typeMap)
    {
        $this->beConstructedWith($serializer, $typeMap);
    }

    function it_deserializes_from_json_by_default(SerializerInterface $serializer, JMSSerializerTypeMap $typeMap)
    {
        $message = $this->createMessage();

        $typeMap->type($message)->willReturn($jmsType = $this->randomString());

        $serializer->deserialize(
            $message->content(),
            $jmsType,
            JMSSerializerSymfonyEventFactory::FORMAT_JSON,
            $this->createContext($message)
        )->willReturn($event = $this->createEvent()
        );

        $this->create($message)->shouldBe($event);
    }

    function it_deserializes_message_content_using_jms_serialiser(
        SerializerInterface $serializer,
        JMSSerializerTypeMap $typeMap
    ) {
        $this->beConstructedWith($serializer, $typeMap, $format = JMSSerializerSymfonyEventFactory::FORMAT_XML);

        $message = $this->createMessage();

        $typeMap->type($message)->willReturn($jmsType = $this->randomString());

        $serializer->deserialize(
            $message->content(),
            $jmsType,
            $format,
            $this->createContext($message)
        )->willReturn($event = $this->createEvent()
        );

        $this->create($message)->shouldBe($event);
    }

    private function createContext(Message $message)
    {
        $context = DeserializationContext::create();
        $context->setAttribute('message', $message);

        return $context;
    }
}
