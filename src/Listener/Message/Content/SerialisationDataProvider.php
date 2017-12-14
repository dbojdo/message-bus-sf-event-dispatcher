<?php

namespace Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Listener\Message\Content;

use Symfony\Component\EventDispatcher\Event;

interface SerialisationDataProvider
{
    /**
     * @param string $eventName
     * @param Event $event
     * @return mixed
     */
    public function getData(string $eventName, Event $event);
}