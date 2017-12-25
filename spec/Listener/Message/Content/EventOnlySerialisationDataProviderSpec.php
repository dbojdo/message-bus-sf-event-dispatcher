<?php

namespace spec\Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Listener\Message\Content;

use spec\Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\AbstractObjectBehaviour;
use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Listener\Message\Content\EventOnlySerialisationDataProvider;

class EventOnlySerialisationDataProviderSpec extends AbstractObjectBehaviour
{
    function it_is_initializable()
    {
        $this->shouldHaveType(EventOnlySerialisationDataProvider::class);
    }

    function it_returns_event_as_data()
    {
        $messageBusEvent = $this->createMessageBusEvent();
        $this->getData($messageBusEvent)->shouldBe($messageBusEvent->event());
    }
}
