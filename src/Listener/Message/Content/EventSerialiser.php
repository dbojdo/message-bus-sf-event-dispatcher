<?php

namespace Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Listener\Message\Content;

use Symfony\Component\EventDispatcher\Event;

interface EventSerialiser
{
    public function serialise(string $eventName, Event $event): string;
}
