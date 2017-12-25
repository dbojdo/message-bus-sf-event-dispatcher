<?php

namespace Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Publisher\Event;

use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\MessageBusEvent;
use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Publisher\Event\Exception\UnsupportedMessageTypeException;
use Webit\MessageBus\Message;

final class ByMessageTypeMessageBusEventFactory implements MessageBusEventFactory
{
    /** @var MessageBusEventFactory[] */
    private $eventFromMessageFactories;

    /**
     * ByMessageTypeEventFromMessageFactory constructor.
     * @param MessageBusEventFactory[] $eventFromMessageFactories
     */
    public function __construct(array $eventFromMessageFactories)
    {
        $this->eventFromMessageFactories = $eventFromMessageFactories;
    }

    /**
     * @inheritdoc
     */
    public function create(Message $message): MessageBusEvent
    {
        if (isset($this->eventFromMessageFactories[$message->type()])) {
            return $this->eventFromMessageFactories[$message->type()]->create($message);
        }

        throw UnsupportedMessageTypeException::fromMessage($message);
    }
}
