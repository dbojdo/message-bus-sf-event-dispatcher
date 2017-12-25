<?php

namespace Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Listener\Message\Content;

use Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\MessageBusEvent;

final class PhpSerializeEventSerialiser implements EventSerialiser
{
    /** @var SerialisationDataProvider */
    private $serialisationDataProvider;

    public function __construct(SerialisationDataProvider $serialisationDataProvider)
    {
        $this->serialisationDataProvider = $serialisationDataProvider;
    }

    /**
     * @inheritdoc
     */
    public function serialise(MessageBusEvent $event): string
    {
        return serialize($this->serialisationDataProvider->getData($event));
    }
}
