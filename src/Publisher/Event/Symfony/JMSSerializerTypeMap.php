<?php

namespace Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Publisher\Event\Symfony;

use Webit\MessageBus\Message;

interface JMSSerializerTypeMap
{
    public function type(Message $message): string;
}
