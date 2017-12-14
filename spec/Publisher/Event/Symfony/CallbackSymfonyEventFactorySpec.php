<?php

namespace spec\Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Publisher\Event\Symfony;

use spec\Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\AbstractObjectBehaviour;
use Symfony\Component\EventDispatcher\Event;
use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Publisher\Event\Symfony\CallbackSymfonyEventFactory;
use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Publisher\Event\Symfony\Exception\InvalidCallableException;
use Webit\MessageBus\Message;

class CallbackSymfonyEventFactorySpec extends AbstractObjectBehaviour
{
    function it_is_initializable()
    {
        $this->shouldHaveType(CallbackSymfonyEventFactory::class);
    }

    function let(Callables $callable)
    {
        $this->beConstructedWith($callable);
    }

    function it_supports_object_method_callable(Callables $callables, Event $event)
    {
        $message = $this->createMessage();

        $this->beConstructedWith([$callables, 'methodToBeCalled']);
        $callables->methodToBeCalled($message)->willReturn($event);
        $this->create($message)->shouldBe($event);
    }

    function it_supports_class_static_method_callable(Callables $callables, Event $event)
    {
        $message = $this->createMessage();
        $this->beConstructedWith(
            'spec\Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Publisher\Event\Symfony\Callables::create'
        );

        Callables::$event = $event->getWrappedObject();

        $this->create($message)->shouldBe($event);
    }

    function it_supports_invokable_objects(Callables $callables, Event $event)
    {
        $message = $this->createMessage();
        $this->beConstructedWith($callables);

        $callables->__invoke($message)->willReturn($event);
        $this->create($message)->shouldBe($event);
    }

    function it_supports_anonymous_function()
    {
        $event = $this->createEvent();
        $callback = function (Message $message) use ($event) {
            return $event;
        };

        $this->beConstructedWith($callback);
        $this->create($this->createMessage())->shouldBe($event);
    }

    function it_supports_named_function()
    {
        $this->beConstructedWith(
            'spec\Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Publisher\Event\Symfony\createEvent'
        );

        $this->create($this->createMessage())->shouldBeLike(new Event());
    }

    function it_throws_exception_on_invalid_callable()
    {
        $this->beConstructedWith($this->randomString());
        $this->shouldThrow(InvalidCallableException::class)->duringInstantiation();
    }
}

abstract class Callables
{
    /** @var Event */
    public static $event;

    public static function create(Message $message)
    {
        return self::$event;
    }

    abstract public function __invoke(Message $message);

    abstract public function methodToBeCalled(Message $message);
}

function createEvent(Message $message)
{
    return new Event();
}
