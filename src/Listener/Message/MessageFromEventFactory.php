<?php

namespace Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Listener\Message;

use Symfony\Component\EventDispatcher\Event;
use Webit\MessageBus\Message;

interface MessageFromEventFactory
{
    public function create(string $eventName, Event $event): Message;
}
