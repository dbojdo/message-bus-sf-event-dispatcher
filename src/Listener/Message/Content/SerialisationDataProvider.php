<?php

namespace Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Listener\Message\Content;

use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\MessageBusEvent;

interface SerialisationDataProvider
{
    /**
     * @param MessageBusEvent $event
     * @return mixed
     */
    public function getData(MessageBusEvent $event);
}