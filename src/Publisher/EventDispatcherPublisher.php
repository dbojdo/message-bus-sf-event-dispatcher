<?php

namespace Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Publisher;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Webit\MessageBus\Publisher\Exception\CannotPublishMessageException;
use Webit\MessageBus\Publisher\Exception\UnsupportedMessageTypeException as PublisherUnsupportedMessageTypeException;
use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Publisher\Event\Exception\EventFromMessageException;
use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Publisher\Event\Exception\UnsupportedMessageTypeException;
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
     * @param MessageBusEventFactory $messageBusEventFactory
     */
    public function __construct(
        EventDispatcherInterface $eventDispatcher,
        MessageBusEventFactory $messageBusEventFactory
    ) {
        $this->eventDispatcher = $eventDispatcher;
        $this->messageBusEventFactory = $messageBusEventFactory;
    }

    /**
     * @inheritdoc
     */
    public function publish(Message $message)
    {
        try {
            $messageBusEvent = $this->messageBusEventFactory->create($message);
        }
        catch (UnsupportedMessageTypeException $e) {
            throw PublisherUnsupportedMessageTypeException::forMessage($message);
        }
        catch (EventFromMessageException $e) {
            throw CannotPublishMessageException::forMessage($message, 0, $e);
        }

        $this->eventDispatcher->dispatch($messageBusEvent->name(), $messageBusEvent->event());
    }
}
