<?php

namespace Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Listener\Message\Content;

use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\MessageBusEvent;

interface EventSerialiser
{
    public function serialise(MessageBusEvent $event): string;
}
