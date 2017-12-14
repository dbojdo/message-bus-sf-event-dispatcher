<?php

namespace Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Publisher\Event\Symfony;

use JMS\Serializer\DeserializationContext;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\EventDispatcher\Event;
use Webit\MessageBus\Message;

final class JMSSerializerSymfonyEventFactory implements SymfonyEventFactory
{
    const FORMAT_JSON = 'json';
    const FORMAT_XML = 'xml';

    /** @var SerializerInterface */
    private $serializer;

    /** @var string */
    private $type;

    /** @var string */
    private $format;

    public function __construct(SerializerInterface $serializer, string $type, string $format = self::FORMAT_JSON)
    {
        $this->serializer = $serializer;
        $this->type = $type;
        $this->format = $format;
    }

    public function create(Message $message): Event
    {
        $this->serializer->deserialize(
            $message->content(),
            $this->type,
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
