<?php

namespace Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Listener\Message\Exception;

use Symfony\Component\EventDispatcher\Event;

abstract class AbstractMessageFromEventException extends \RuntimeException implements MessageFromEventException
{
    /** @var string */
    private $eventName;

    /** @var Event */
    private $event;

    public static function fromEvent(
        string $eventName,
        Event $event,
        $code = 0,
        \Exception $previous = null
    ): MessageFromEventException {
        $exception = new static(
            static::exceptionMessage($eventName, $event),
            $code,
            $previous
        );

        $exception->eventName = $eventName;
        $exception->event = $event;

        return $exception;
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
    public function event(): Event
    {
        return $this->event;
    }

    abstract protected static function exceptionMessage(string $eventName, Event $event): string;
}