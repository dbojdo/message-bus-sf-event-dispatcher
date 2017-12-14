<?php

namespace Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Publisher\Event\Symfony;

use Symfony\Component\EventDispatcher\Event;
use Webit\MessageBus\Message;

interface SymfonyEventFactory
{
    public function create(Message $message): Event;
}