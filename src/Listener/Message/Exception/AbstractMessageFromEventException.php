<?php

namespace Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Listener\Message\Exception;

use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\MessageBusEvent;

abstract class AbstractMessageFromEventException extends \RuntimeException implements MessageFromEventException
{
    /** @var MessageBusEvent */
    private $event;

    public static function fromEvent(
        MessageBusEvent $event,
        $code = 0,
        \Exception $previous = null
    ): MessageFromEventException {
        $exception = new static(
            static::exceptionMessage($event),
            $code,
            $previous
        );

        $exception->event = $event;

        return $exception;
    }
    public function event(): MessageBusEvent
    {
        return $this->event;
    }

    abstract protected static function exceptionMessage(MessageBusEvent $event): string;
}