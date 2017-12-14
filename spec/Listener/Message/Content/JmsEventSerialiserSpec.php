<?php

namespace spec\Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Listener\Message\Content;

use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use spec\Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\AbstractObjectBehaviour;
use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Listener\Message\Content\JmsEventSerialiser;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Listener\Message\Content\SerialisationDataProvider;

class JmsEventSerialiserSpec extends AbstractObjectBehaviour
{
    function it_is_initializable()
    {
        $this->shouldHaveType(JmsEventSerialiser::class);
    }

    function let(SerializerInterface $serializer, SerialisationDataProvider $dataProvider)
    {
        $this->beConstructedWith($serializer, $dataProvider, JmsEventSerialiser::FORMAT_XML);
    }

    function it_serialises_event_using_jms_serialiser(
        SerializerInterface $serializer,
        SerialisationDataProvider $dataProvider
    ) {
        $eventName = $this->randomString();
        $event = $this->createEvent();
        $dataProvider->getData($eventName, $event)->willReturn($dataToBeSerialised = [$this->randomString()]);

        $serializer
            ->serialize(
                $dataToBeSerialised,
                JmsEventSerialiser::FORMAT_XML,
                $this->createContext($eventName, $event)
            )
            ->willReturn($serialisedData = $this->randomString());

        $this->serialise($eventName, $event)->shouldBe($serialisedData);
    }

    function it_serialises_plain_event_when_data_provider_not_set(SerializerInterface $serializer)
    {
        $this->beConstructedWith($serializer, null, JmsEventSerialiser::FORMAT_XML);

        $eventName = $this->randomString();
        $event = $this->createEvent();

        $serializer
            ->serialize(
                $event,
                JmsEventSerialiser::FORMAT_XML,
                $this->createContext($eventName, $event)
            )
            ->willReturn($serialisedData = $this->randomString());

        $this->serialise($eventName, $event)->shouldBe($serialisedData);
    }

    function it_serialises_to_json_when_format_not_set(SerializerInterface $serializer)
    {
        $this->beConstructedWith($serializer);

        $eventName = $this->randomString();
        $event = $this->createEvent();

        $serializer
            ->serialize(
                $event,
                JmsEventSerialiser::FORMAT_JSON,
                $this->createContext($eventName, $event)
            )
            ->willReturn($serialisedData = $this->randomString());

        $this->serialise($eventName, $event)->shouldBe($serialisedData);
    }

    private function createContext($eventName, $event)
    {
        $serializationContext = SerializationContext::create();
        $serializationContext->attributes->set('eventName', $eventName);
        $serializationContext->attributes->set('event', $event);

        return$serializationContext;
    }
}
