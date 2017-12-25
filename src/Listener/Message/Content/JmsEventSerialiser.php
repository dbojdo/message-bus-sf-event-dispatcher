<?php

namespace Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Listener\Message\Content;

use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\EventDispatcher\Event;
use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\MessageBusEvent;

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

    public function serialise(MessageBusEvent $event): string
    {
        $data = $this->dataProvider->getData($event);
        return $this->serializer->serialize(
            $data,
            $this->format,
            $this->createContext($event)
        );
    }

    private function createContext(MessageBusEvent $event): SerializationContext
    {
        $context = SerializationContext::create();
        $context->attributes->set('event', $event);

        return $context;
    }
}
