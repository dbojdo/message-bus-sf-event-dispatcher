<?php

namespace Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Listener\Message\Content;

use Symfony\Component\EventDispatcher\Event;

final class EventOnlySerialisationDataProvider implements SerialisationDataProvider
{
    /**
     * @inheritdoc
     */
    public function getData(string $eventName, Event $event)
    {
        return $event;
    }
}