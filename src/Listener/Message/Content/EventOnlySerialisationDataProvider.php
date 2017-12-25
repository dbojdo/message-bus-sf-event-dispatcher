<?php

namespace Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Listener\Message\Content;

use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\MessageBusEvent;

final class EventOnlySerialisationDataProvider implements SerialisationDataProvider
{
    /**
     * @inheritdoc
     */
    public function getData(MessageBusEvent $event)
    {
        return $event->event();
    }
}