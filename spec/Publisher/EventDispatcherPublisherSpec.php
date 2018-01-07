<?php

namespace spec\Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Publisher;

use Prophecy\Argument;
use spec\Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\AbstractObjectBehaviour;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Webit\MessageBus\Publisher\Exception\CannotPublishMessageException;
use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Publisher\Event\Exception\CannotCreateEventFromMessageException;
use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Publisher\Event\MessageBusEventFactory;
use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Publisher\EventDispatcherPublisher;
use Webit\MessageBus\Publisher\Exception\UnsupportedMessageTypeException;
use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Publisher\Event\Exception\UnsupportedMessageTypeException as SymfonyUnsupportedMessageTypeException;
class EventDispatcherPublisherSpec extends AbstractObjectBehaviour
{
    function it_is_initializable()
    {
        $this->shouldHaveType(EventDispatcherPublisher::class);
    }

    function let(EventDispatcherInterface $eventDispatcher, MessageBusEventFactory $messageBusEventFactory)
    {
        $this->beConstructedWith($eventDispatcher, $messageBusEventFactory);

    }

    function it_dispatches_event_from_message(EventDispatcherInterface $eventDispatcher, MessageBusEventFactory $messageBusEventFactory)
    {
        $message = $this->createMessage();

        $messageBusEventFactory->create($message)->willReturn(
            $messageBusEvent = $this->createMessageBusEvent()
        );

        $eventDispatcher->dispatch($messageBusEvent->name(), $messageBusEvent->event())->shouldBeCalled();

        $this->publish($message);
    }

    function it_throws_publication_exception_on_message_creation_exception(EventDispatcherInterface $eventDispatcher, MessageBusEventFactory $messageBusEventFactory)
    {
        $message = $this->createMessage();

        $messageBusEventFactory->create($message)->willThrow(CannotCreateEventFromMessageException::class);
        $eventDispatcher->dispatch(Argument::any(), Argument::any())->shouldNotBeCalled();

        $this->shouldThrow(CannotPublishMessageException::class)->duringPublish($message);
    }

    function it_throws_publication_exception_on_any_exception(EventDispatcherInterface $eventDispatcher, MessageBusEventFactory $messageBusEventFactory)
    {
        $message = $this->createMessage();

        $messageBusEventFactory->create($message)->willThrow(\Exception::class);
        $eventDispatcher->dispatch(Argument::any(), Argument::any())->shouldNotBeCalled();

        $this->shouldThrow(CannotPublishMessageException::class)->duringPublish($message);
    }

    function it_throws_unsupported_message_type_exception_when_message_not_supported(EventDispatcherInterface $eventDispatcher, MessageBusEventFactory $messageBusEventFactory)
    {
        $message = $this->createMessage();

        $messageBusEventFactory->create($message)->willThrow(SymfonyUnsupportedMessageTypeException::class);
        $eventDispatcher->dispatch(Argument::any(), Argument::any())->shouldNotBeCalled();

        $this->shouldThrow(UnsupportedMessageTypeException::class)->duringPublish($message);
    }
}
