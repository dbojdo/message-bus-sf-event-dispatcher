<?php

namespace Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Listener;

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Webit\MessageBus\Consumer;
use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Listener\Message\MessageFromEventFactory;
use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\MessageBusEvent;

final class EventConsumingListener implements EventDispatcherListener
{
    /** @var Consumer */
    private $consumer;

    /** @var MessageFromEventFactory */
    private $messageFromEvent;

    /**
     * EventConsumingListener constructor.
     * @param Consumer $consumer
     * @param MessageFromEventFactory $messageFromEvent
     */
    public function __construct(Consumer $consumer, MessageFromEventFactory $messageFromEvent)
    {
        $this->consumer = $consumer;
        $this->messageFromEvent = $messageFromEvent;
    }

    /**
     * @inheritdoc
     */
    public function onEvent(Event $event, $eventName, EventDispatcherInterface $eventDispatcher)
    {
        $message = $this->messageFromEvent->create(new MessageBusEvent($eventName, $event));
        $this->consumer->consume($message);
    }
}
