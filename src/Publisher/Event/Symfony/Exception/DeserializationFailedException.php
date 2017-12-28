<?php

namespace Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Publisher\Event\Symfony\Exception;

use Webit\MessageBus\Message;

class DeserializationFailedException extends \RuntimeException
{
    public static function create()
    {
        return new self('Could not "unserialize" the message content.');
    }
}