<?php

namespace Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Listener\Message\Type;

use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\MessageBusEvent;

interface MessageTypeResolver
{
    public function resolve(MessageBusEvent $event): string;
}
