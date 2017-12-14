<?php

namespace Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Listener\Message\Content;

use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\EventDispatcher\Event;

final class JmsEventSerialiser implements EventSerialiser
{
    const FORMAT_JSON = 'json';
    const FORMAT_XML = 'xml';

    /** @var SerializerInterface */
    private $serializer;

    /** @var SerialisationDataProvider */
    private $dataProvider;

    /** @var string */
    private $format;

    public function __construct(
        SerializerInterface $serializer,
        SerialisationDataProvider $dataProvider = null,
        string $format = self::FORMAT_JSON
    ) {
        $this->serializer = $serializer;
        $this->dataProvider = $dataProvider ?: new EventOnlySerialisationDataProvider();
        $this->format = $format;
    }

    public function serialise(string $eventName, Event $event): string
    {
        $data = $this->dataProvider->getData($eventName, $event);
        return $this->serializer->serialize(
            $data,
            $this->format,
            $this->createContext($eventName, $event)
        );
    }

    private function createContext(string $eventName, Event $event): SerializationContext
    {
        $context = SerializationContext::create();
        $context->attributes->set('eventName', $eventName);
        $context->attributes->set('event', $event);

        return $context;
    }
}
