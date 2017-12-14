<?php

namespace Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Publisher\Event\Name;

use Webit\MessageBus\Message;

final class FromMessageTypeEventNameResolver implements EventNameResolver
{
    public function resolve(Message $message): string
    {
        return $message->type();
    }
}