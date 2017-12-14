<?php

namespace Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Publisher\Event;

use Webit\MessageBus\Message;

interface EventToBeDispatchedFactory
{
    /**
     * @param Message $message
     * @return EventToBeDispatched
     * @throws Exception\EventFromMessageException
     */
    public function create(Message $message): EventToBeDispatched;
}
