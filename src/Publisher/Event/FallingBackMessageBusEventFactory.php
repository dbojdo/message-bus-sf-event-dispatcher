<?php

namespace Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Publisher\Event;

use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\MessageBusEvent;
use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Publisher\Event\Exception\EventFromMessageException;
use Webit\MessageBus\Message;

final class FallingBackMessageBusEventFactory implements MessageBusEventFactory
{
    /** @var MessageBusEventFactory */
    private $innerFactory;

    /** @var MessageBusEventFactory */
    private $fallbackFactory;

    /**
     * FallingBackEventFromMessageFactory constructor.
     * @param MessageBusEventFactory $innerFactory
     * @param MessageBusEventFactory $fallbackFactory
     */
    public function __construct(MessageBusEventFactory $innerFactory, MessageBusEventFactory $fallbackFactory)
    {
        $this->innerFactory = $innerFactory;
        $this->fallbackFactory = $fallbackFactory;
    }

    /**
     * @inheritdoc
     */
    public function create(Message $message): MessageBusEvent
    {
        try {
            return $this->innerFactory->create($message);
        } catch (EventFromMessageException $e) {
            return $this->fallbackFactory->create($message);
        }
    }
}
