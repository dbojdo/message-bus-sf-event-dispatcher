<?php

namespace Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Publisher;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Publisher\Event\EventToBeDispatchedFactory;
use Webit\MessageBus\Message;
use Webit\MessageBus\Publisher;

final class EventDispatcherPublisher implements Publisher
{
    /** @var EventDispatcherInterface */
    private $eventDispatcher;

    /** @var EventToBeDispatchedFactory */
    private $eventToBeDispatchedFactory;

    /**
     * EventDispatcherPublisher constructor.
     * @param EventDispatcherInterface $eventDispatcher
     * @param EventToBeDispatchedFactory $eventToBeDispatchedFactory
     */
    public function __construct(
        EventDispatcherInterface $eventDispatcher,
        EventToBeDispatchedFactory $eventToBeDispatchedFactory
    ) {
        $this->eventDispatcher = $eventDispatcher;
        $this->eventToBeDispatchedFactory = $eventToBeDispatchedFactory;
    }

    /**
     * @inheritdoc
     */
    public function publish(Message $message)
    {
        $eventToBeDispatched = $this->eventToBeDispatchedFactory->create($message);
        $this->eventDispatcher->dispatch($eventToBeDispatched->eventName(), $eventToBeDispatched->event());
    }
}
