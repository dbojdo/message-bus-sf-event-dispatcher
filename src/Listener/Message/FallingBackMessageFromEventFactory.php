<?php

namespace Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Listener\Message;

use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Listener\Message\Exception\MessageFromEventException;
use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\MessageBusEvent;
use Webit\MessageBus\Message;

final class FallingBackMessageFromEventFactory implements MessageFromEventFactory
{
    /** @var MessageFromEventFactory */
    private $factory;

    /** @var MessageFromEventFactory */
    private $fallbackFactory;

    /**
     * FallingBackMessageFromEventFactory constructor.
     * @param MessageFromEventFactory $factory
     * @param MessageFromEventFactory $fallbackFactory
     */
    public function __construct(MessageFromEventFactory $factory, MessageFromEventFactory $fallbackFactory)
    {
        $this->factory = $factory;
        $this->fallbackFactory = $fallbackFactory;
    }

    public function create(MessageBusEvent $event): Message
    {
        try {
            return $this->factory->create($event);
        } catch (MessageFromEventException $e) {
            return $this->fallbackFactory->create($event);
        }
    }
}
