<?php

namespace Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Listener\Message;

use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Listener\Message\Exception\UnsupportedEventException;
use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\MessageBusEvent;
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

    public function create(MessageBusEvent $event): Message
    {
        if (isset($this->factories[$event->name()])) {
            return $this->factories[$event->name()]->create($event);
        }

        throw UnsupportedEventException::fromEvent($event);
    }
}
