<?php

namespace Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Publisher\Event\Symfony;

use Symfony\Component\EventDispatcher\Event;
use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Publisher\Event\Symfony\Exception\InvalidCallableException;
use Webit\MessageBus\Message;

final class CallbackSymfonyEventFactory implements SymfonyEventFactory
{
    /** @var callable */
    private $callable;

    /**
     * DirectSymfonyEventFactory constructor.
     * @param callable|string $callable
     */
    public function __construct($callable)
    {
        if (!is_callable($callable)) {
            throw InvalidCallableException::fromCallable($callable);
        }
        $this->callable = $callable;
    }

    public function create(Message $message): Event
    {
        return call_user_func($this->callable, $message);
    }
}
