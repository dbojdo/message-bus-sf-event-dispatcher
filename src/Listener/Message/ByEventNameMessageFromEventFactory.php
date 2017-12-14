<?php

namespace Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Listener\Message;

use Symfony\Component\EventDispatcher\Event;
use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Listener\Message\Exception\UnsupportedEventException;
use Webit\MessageBus\Message;

final class ByEventNameMessageFromEventFactory implements MessageFromEventFactory
{
    /** @var MessageFromEventFactory[] */
    private $factories;

    /**
     * ByEventNameMessageFromEventFactory constructor.
     * @param MessageFromEventFactory[] $factories
     */
    public function __construct(array $factories)
    {
        $this->factories = $factories;
    }

    public function create(string $eventName, Event $event): Message
    {
        if (isset($this->factories[$eventName])) {
            return $this->factories[$eventName]->create($eventName, $event);
        }

        throw UnsupportedEventException::fromEvent($eventName, $event);
    }
}
