<?php

namespace Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Listener\Message\Type;

use Symfony\Component\EventDispatcher\Event;

interface MessageTypeResolver
{
    public function resolve(string $eventName, Event $event): string;
}
