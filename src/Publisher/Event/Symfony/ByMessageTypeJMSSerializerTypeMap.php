<?php

namespace Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Publisher\Event\Symfony;

use Webit\MessageBus\Message;

final class ByMessageTypeJMSSerializerTypeMap implements JMSSerializerTypeMap
{
    /** @var string[] */
    private $typeMap;

    /**
     * @param string[] $typeMap
     */
    public function __construct(array $typeMap = [])
    {
        $this->typeMap = $typeMap;
    }

    public function type(Message $message): string
    {
        return $this->typeMap[$message->type()] ?? $message->type();
    }
}
