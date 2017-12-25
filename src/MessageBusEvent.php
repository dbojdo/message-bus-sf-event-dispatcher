<?php

namespace Webit\MessageBus\Infrastructure\Symfony\EventDispatcher;

use Symfony\Component\EventDispatcher\Event;

final class MessageBusEvent
{
    /** @var string */
    private $name;

    /** @var Event */
    private $event;

    /**
     * Event constructor.
     * @param string $name
     * @param Event $event
     */
    public function __construct(string $name, Event $event)
    {
        $this->name = $name;
        $this->event = $event;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function event(): Event
    {
        return $this->event;
    }
}