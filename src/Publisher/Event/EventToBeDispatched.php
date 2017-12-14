<?php

namespace Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Publisher\Event;

use Symfony\Component\EventDispatcher\Event;

final class EventToBeDispatched
{
    /** @var string */
    private $eventName;

    /** @var Event */
    private $event;

    /**
     * EventToBeDispatched constructor.
     * @param string $eventName
     * @param Event $event
     */
    public function __construct($eventName, Event $event = null)
    {
        $this->eventName = $eventName;
        $this->event = $event;
    }

    /**
     * @return string
     */
    public function eventName(): string
    {
        return $this->eventName;
    }

    /**
     * @return Event
     */
    public function event()
    {
        return $this->event;
    }
}
