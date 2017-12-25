<?php

namespace Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Publisher\Event;

use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\MessageBusEvent;
use Webit\MessageBus\Message;

interface MessageBusEventFactory
{
    /**
     * @param Message $message
     * @return MessageBusEvent
     * @throws Exception\EventFromMessageException
     */
    public function create(Message $message): MessageBusEvent;
}
