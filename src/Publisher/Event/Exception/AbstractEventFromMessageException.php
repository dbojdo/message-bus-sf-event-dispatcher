<?php


namespace Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Publisher\Event\Exception;

use Webit\MessageBus\Message;

abstract class AbstractEventFromMessageException extends \RuntimeException implements EventFromMessageException
{
    /** @var Message */
    private $messageBusMessage;

    public static function fromMessage(
        Message $message,
        $code = 0,
        \Exception $previous = null
    ): EventFromMessageException {
        $exception = new static(
            static::exceptionMessage($message),
            $code,
            $previous
        );

        $exception->messageBusMessage = $message;

        return $exception;
    }

    public function messageBusMessage(): Message
    {
        return $this->message;
    }

    abstract protected static function exceptionMessage(Message $message): string;
}