<?php

namespace spec\Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Listener\Message\Content;

use spec\Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\AbstractObjectBehaviour;
use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Listener\Message\Content\PhpSerializeEventSerialiser;
use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Listener\Message\Content\SerialisationDataProvider;

class PhpSerializeEventSerialiserSpec extends AbstractObjectBehaviour
{
    function it_is_initializable()
    {
        $this->shouldHaveType(PhpSerializeEventSerialiser::class);
    }

    function let(SerialisationDataProvider $dataProvider)
    {
        $this->beConstructedWith($dataProvider);
    }

    function it_serialises_given_data_using_php_serialize_method(SerialisationDataProvider $dataProvider)
    {
        $messageBusEvent = $this->createMessageBusEvent();

        $dataToBeSerialised = $messageBusEvent->event();
        $dataProvider->getData($messageBusEvent)->willReturn($dataToBeSerialised);

        $this->serialise($messageBusEvent)->shouldBe(serialize($dataToBeSerialised));
    }
}
