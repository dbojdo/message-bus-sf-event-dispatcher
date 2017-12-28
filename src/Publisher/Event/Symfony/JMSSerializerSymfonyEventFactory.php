<?php

namespace Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Publisher\Event\Symfony;

use JMS\Serializer\DeserializationContext;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\EventDispatcher\Event;
use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Publisher\Event\Exception\CannotCreateEventFromMessageException;
use Webit\MessageBus\Message;

final class JMSSerializerSymfonyEventFactory implements SymfonyEventFactory
{
    const FORMAT_JSON = 'json';
    const FORMAT_XML = 'xml';

    /** @var SerializerInterface */
    private $serializer;

    /** @var JMSSerializerTypeMap */
    private $typeMap;

    /** @var string */
    private $format;


    public function __construct(SerializerInterface $serializer, JMSSerializerTypeMap $typeMap, string $format = self::FORMAT_JSON)
    {
        $this->serializer = $serializer;
        $this->format = $format;
        $this->typeMap = $typeMap;
    }

    public function create(Message $message): Event
    {
        return $this->serializer->deserialize(
            $message->content(),
            $this->typeMap->type($message),
            $this->format,
            $this->createContext($message)
        );
    }

    private function createContext(Message $message): DeserializationContext
    {
        $context = DeserializationContext::create();
        $context->attributes->set('message', $message);

        return $context;
    }
}
