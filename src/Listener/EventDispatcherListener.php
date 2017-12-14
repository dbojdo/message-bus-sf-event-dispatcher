<?php

namespace Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Listener;

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

interface EventDispatcherListener
{
    /**
     * @param Event $event
     * @param string $eventName
     * @param EventDispatcherInterface $eventDispatcher
     * @return mixed
     */
    public function onEvent(Event $event, $eventName, EventDispatcherInterface $eventDispatcher);
}