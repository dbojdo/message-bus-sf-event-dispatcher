<?php

namespace Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Listener\Message;

use Webit\MessageBus\Message;

interface MessageAwareEvent
{
    public function createMessage(string $eventName): Message;
}