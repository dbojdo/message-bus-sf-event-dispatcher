<?php

namespace Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Publisher\Event;

use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Publisher\Event\Exception\CannotCreateEventFromMessageException;
use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Publisher\Event\Name\EventNameResolver;
use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Publisher\Event\Name\FromMessageTypeEventNameResolver;
use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Publisher\Event\Symfony\SymfonyEventFactory;
use Webit\MessageBus\Message;

final class GenericEventToBeDispatchedFactory implements EventToBeDispatchedFactory
{
    /** @var SymfonyEventFactory */
    private $symfonyEventFactory;

    /** @var EventNameResolver */
    private $eventNameResolver;

    /**
     * GenericEventToBeDispatchedFactory constructor.
     * @param SymfonyEventFactory $symfonyEventFactory
     * @param EventNameResolver $eventNameResolver
     */
    public function __construct(SymfonyEventFactory $symfonyEventFactory, EventNameResolver $eventNameResolver = null)
    {
        $this->symfonyEventFactory = $symfonyEventFactory;
        $this->eventNameResolver = $eventNameResolver ?: new FromMessageTypeEventNameResolver();
    }

    /**
     * @inheritdoc
     */
    public function create(Message $message): EventToBeDispatched
    {
        try {
            return new EventToBeDispatched(
                $this->eventNameResolver->resolve($message),
                $this->symfonyEventFactory->create($message)
            );
        } catch (\Exception $e) {
            throw CannotCreateEventFromMessageException::fromMessage($message, 0, $e);
        }
    }
}
