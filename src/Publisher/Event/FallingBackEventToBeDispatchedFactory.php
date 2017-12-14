<?php

namespace Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Publisher\Event;

use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Publisher\Event\Exception\EventFromMessageException;
use Webit\MessageBus\Message;

final class FallingBackEventToBeDispatchedFactory implements EventToBeDispatchedFactory
{
    /** @var EventToBeDispatchedFactory */
    private $innerFactory;

    /** @var EventToBeDispatchedFactory */
    private $fallbackFactory;

    /**
     * FallingBackEventFromMessageFactory constructor.
     * @param EventToBeDispatchedFactory $innerFactory
     * @param EventToBeDispatchedFactory $fallbackFactory
     */
    public function __construct(EventToBeDispatchedFactory $innerFactory, EventToBeDispatchedFactory $fallbackFactory)
    {
        $this->innerFactory = $innerFactory;
        $this->fallbackFactory = $fallbackFactory;
    }

    /**
     * @inheritdoc
     */
    public function create(Message $message): EventToBeDispatched
    {
        try {
            return $this->innerFactory->create($message);
        } catch (EventFromMessageException $e) {
            return $this->fallbackFactory->create($message);
        }
    }
}
