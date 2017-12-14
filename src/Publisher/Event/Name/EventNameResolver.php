<?php

namespace Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Publisher\Event\Name;

use Webit\MessageBus\Message;

interface EventNameResolver
{
    public function resolve(Message $message): string;
}