<?php

namespace Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Publisher;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Publisher\Event\MessageBusEventFactory;
use Webit\MessageBus\Message;
use Webit\MessageBus\Publisher;

final class EventDispatcherPublisher implements Publisher
{
    /** @var EventDispatcherInterface */
    private $eventDispatcher;

    /** @var MessageBusEventFactory */
    private $messageBusEventFactory;

    /**
     * EventDispatcherPublisher constructor.
     * @param EventDispatcherInterface $eventDispatcher
     * @param MessageBusEventFactory $eventToBeDispatchedFactory
     */
    public function __construct(
        EventDispatcherInterface $eventDispatcher,
        MessageBusEventFactory $eventToBeDispatchedFactory
    ) {
        $this->eventDispatcher = $eventDispatcher;
        $this->messageBusEventFactory = $eventToBeDispatchedFactory;
    }

    /**
     * @inheritdoc
     */
    public function publish(Message $message)
    {
        $messageBusEvent = $this->messageBusEventFactory->create($message);
        $this->eventDispatcher->dispatch($messageBusEvent->name(), $messageBusEvent->event());
    }
}
