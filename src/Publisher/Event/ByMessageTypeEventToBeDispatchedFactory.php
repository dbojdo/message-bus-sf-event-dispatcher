<?php

namespace Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Publisher\Event;

use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Publisher\Event\Exception\UnsupportedMessageTypeException;
use Webit\MessageBus\Message;

final class ByMessageTypeEventToBeDispatchedFactory implements EventToBeDispatchedFactory
{
    /** @var EventToBeDispatchedFactory[] */
    private $eventFromMessageFactories;

    /**
     * ByMessageTypeEventFromMessageFactory constructor.
     * @param EventToBeDispatchedFactory[] $eventFromMessageFactories
     */
    public function __construct(array $eventFromMessageFactories)
    {
        $this->eventFromMessageFactories = $eventFromMessageFactories;
    }

    /**
     * @inheritdoc
     */
    public function create(Message $message): EventToBeDispatched
    {
        if (isset($this->eventFromMessageFactories[$message->type()])) {
            return $this->eventFromMessageFactories[$message->type()]->create($message);
        }

        throw UnsupportedMessageTypeException::fromMessage($message);
    }
}
