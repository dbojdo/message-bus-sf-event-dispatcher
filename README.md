# Message Bus - Symfony Event Dispatcher Infrastructure

Symfony Event Dispatcher infrastructure for Message Bus

## Installation

```bash
composer require webit/message-bus-sf-event-dispatcher=^1.0.0
```

## Usage

### Publisher integration

To publish ***Message*** via Symfony Event Dispatcher use ***EventDispatcherPublisher***

### EventToBeDispatchedFactory

You need to tell the ***EventDispatcherPublisher*** how to translate your ***Message***
into the event name and event object of Symfony Event Dispatcher.
Implement and configure ***EventToBeDispatchedFactory***.

#### EventToBeDispatchedFactory: Example
Let's say you're going to publish messages of two types: **type-1** and **type-2**
and you want to map then to two different Events of Symfony Event Dispatcher **Event1** and **Event2**.

```php
use Symfony\Component\EventDispatcher\Event;

class Event1 extends Event
{
    private $x;
    
    public function __construct($x) {
        $this->x = $x;
    }
    
    public function x()
    {
        return $this->x;
    }
}

class Event2 extends Event
{
    private $y;
    
    private $z;
    
    public function __construct($y, $z) {
        $this->y = $y;
        $this->z = $z;
    }
    
    public function y()
    {
        return $this->y;
    }
    
    public function z()
    {
        return $this->z;
    }
}
```

##### Option 1: implement EventToBeDispatchedFactory

```php
use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Publisher\Event\EventToBeDispatchedFactory;

class Event1ToBeDispatchedFactory implements EventToBeDispatchedFactory
{
    public function create(Message $message): EventToBeDispatched
    {
        $arContent = json_decode($message->content(), true);
        return new EventToBeDispatched(
            $message->type(),
            new Event1(isset($arContent['x']) ? $arContent['x'] : '') 
        );
    }
}

class Event2ToBeDispatchedFactory implements EventToBeDispatchedFactory
{
    public function create(Message $message): EventToBeDispatched
    {
        $arContent = json_decode($message->content(), true);
        return new EventToBeDispatched(
            $message->type(),
            new Event2(
                isset($arContent['y']) ? $arContent['y'] : '',
                isset($arContent['z']) ? $arContent['z'] : '',
            ) 
        );
    }
}
```

Then combine both factories together

```php
use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Publisher\Event\ByMessageTypeEventToBeDispatchedFactory;
$eventToBeDispatchedFactory = new ByMessageTypeEventToBeDispatchedFactory([
    'type-1' => new Event1ToBeDispatchedFactory(),
    'type-2' => new Event2ToBeDispatchedFactory()
]);
```


##### Option 2: Use GenericEventToBeDispatcherFactory and implement its dependencies

```php
use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Publisher\Event\Symfony\CallbackSymfonyEventFactory;

$eventFactory1 = new CallbackSymfonyEventFactory(
    function (Message $message) {
        $arContent = json_decode($message->content(), true);
        return new EventToBeDispatched(
            $message->type(),
            new Event1(isset($arContent['x']) ? $arContent['x'] : '') 
        );
    }
);

$eventFactory2 = new CallbackSymfonyEventFactory(
    function (Message $message) {
        $arContent = json_decode($message->content(), true);
        return new EventToBeDispatched(
            $message->type(),
            new Event2(
                isset($arContent['y']) ? $arContent['y'] : '',
                isset($arContent['z']) ? $arContent['z'] : '',
            ) 
        );
    }
);
```

then

```php
use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Publisher\Event\GenericEventToBeDispatchedFactory;
$eventToBeDispatchedFactory1 = new GenericEventToBeDispatchedFactory(
    $eventFactory1,
    new FromMessageTypeEventNameResolver() // optional, used be default, you can provide a different implemenation
);

$eventToBeDispatchedFactory2 = new GenericEventToBeDispatchedFactory(
    $eventFactory2
);

// combine both factories together
use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Publisher\Event\ByMessageTypeEventToBeDispatchedFactory;

$eventToBeDispatchedFactory = new ByMessageTypeEventToBeDispatchedFactory([
    'type-1' => $eventToBeDispatchedFactory1,
    'type-2' => $eventToBeDispatchedFactory2
]);
```

##### Option 3: Implement your own strategy

As ***EventDispatcherPublisher*** expects an interface ***EventToBeDispatchedFactory*** as a dependency,
you can provide your own implementation for it. Also you can provide and combine
inner interfaces used by ***GenericEventToBeDispatchedFactory***: ***SymfonyEventFactory*** and ***EventNameResolver***.

If you like [JMSSerializer](https://jmsyst.com/libs/serializer) to produce Symfony Event object, use ***JMSSerializerSymfonyEventFactory***.

#### Putting the stuff together

```php
use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Publisher\EventDispatcherPublisher;
use Webit\MessageBus\Message;
use Symfony\Component\EventDispatcher\EventDispatcher;

$eventDispatcher = new EventDispatcher(); 

$publisher = new EventDispatcherPublisher(
    $eventDispatcher,
    $eventToBeDispatchedFactory
);

$message = new Message('type-1', '{"x":"some-x"}');
$publisher->publish($message); // will be dispatched as "event-1" and event of "Event1" class

$message = new Message('type-2', '{"y":"some-y","z":"some-z"}');
$publisher->publish($message); // will be dispatched as "event-1" and event of "Event1" class

```

### Event consumption

#### Why to consume events at all?

 1. Dispatches public events to the Message Bus
    If you want some events to be public and other applications be able to listen to them,
    use ***PublishingConsumer*** to publish them using different infrastructure (AMQP for example). 
    
 2. Asynchronous events processing
    If you want some events to be processed asynchronously,
    use ***PublishingConsumer*** to publish them using different infrastructure (AMQP for example),
    then listen for them.

To consume ***Message*** created from Event of Symfony Event Dispatcher, use ***EventConsumingListener***.
It requires ***MessageFromEventFactory*** and ***Consumer*** to be provided.

#### GenericMessageFromEventFactory

It requires ***EventSerialiser*** and ***MessageTypeResolver*** (by default uses event name)

##### Option 1: Implement own EventSerialiser

```php
use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Listener\Message\Content\EventSerialiser;
use Symfony\Component\EventDispatcher\Event;

class Event1Serializer implements EventSerialiser
{
    public function serialise(string $eventName, Event $event): string
    {
        if ($event instanceof Event1) {
            return json_encode(['x' => $event->x()]);
        }
        throw new \InvalidArgumentException('Event must be an instance of Event1.');
    }
}
```

##### Option 2: Use JMSSerializer to Serialise Event

```php
use JMS\Serializer\SerializerBuilder;
use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Listener\Message\Content\JmsEventSerialiser;
use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Listener\Message\Content\EventOnlySerialisationDataProvider;

$serializerBuilder = SerializerBuilder::create();

// configure Serializer

$serializer = $serializerBuilder->build();

$jsmEventSerialiser = new JmsEventSerialiser(
    $serializer,
    new EventOnlySerialisationDataProvider(), // used by default, provides data to be passed to the JMSSerializer,
    JmsEventSerialiser::FORMAT_JSON // JSON by default, can be JmsEventSerialiser::FORMAT_XML as well
);
```

#### Use FromMessageAwareEventMessageFromEventFactory

Your event can optionally implements ***MessageAwareEvent*** interface.

```php
use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Listener\Message\MessageAwareEvent;
use Symfony\Component\EventDispatcher\Event;

class EventX extends Event implements MessageAwareEvent
{
    public function createMessage(string $eventName): Message
    {
        return new Message($eventName, json_decode(['some'=>'stuff']));
    }
}
```

Then you can use ***FromMessageAwareEventMessageFromEventFactory*** to produce an event

#### Putting all together

Configure ***MessageFromEventFactory***

```php
use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Listener\Message\ByEventNameMessageFromEventFactory;

$messageFactory = new ByEventNameMessageFromEventFactory([
    'type-1' => new GenericMessageFromEventFactory(
        new Event1Serializer()
    ),
    'type-2' => new GenericMessageFromEventFactory($jsmEventSerialiser)
]);
```

Create a listener

```php
use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Listener\EventConsumingListener;

$listener = new EventConsumingListener(
    new VoidConsumer(),
    $messageFactory
);
```

Register the listener on Symfony Event Dispatcher for all required events

```php
$eventDispatcher->addListener('type-1', $listener);
$eventDispatcher->addListener('type-2', $listener);

// will produce new Message('type-1', '{"x":"xxx"}') and pass to the consumer
$eventDispatcher->dispatch('type-1', new Event1('xxx'));
```

## Running tests

Install dependencies with composer

```bash
docker-compose run --rm composer
docker-compose run --rm spec
```
