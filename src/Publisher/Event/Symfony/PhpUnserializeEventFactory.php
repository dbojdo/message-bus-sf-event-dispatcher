<?php

namespace Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Publisher\Event\Symfony;

use Symfony\Component\EventDispatcher\Event;
use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Publisher\Event\Symfony\Exception\DeserializationFailedException;
use Webit\MessageBus\Message;

final class PhpUnserializeEventFactory implements SymfonyEventFactory
{
    /**
     * @inheritdoc
     */
    public function create(Message $message): Event
    {
        $deserialised = @unserialize($message->content());

        if ($deserialised === false) {
            throw DeserializationFailedException::create();
        }

        return $deserialised;
    }
}
