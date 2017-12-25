<?php

namespace Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Publisher\Event\Symfony;

use Symfony\Component\EventDispatcher\Event;
use Webit\MessageBus\Message;

final class PhpUnserializeEventFactory implements SymfonyEventFactory
{
    /**
     * @inheritdoc
     */
    public function create(Message $message): Event
    {
        return unserialize($message->content());
    }
}
