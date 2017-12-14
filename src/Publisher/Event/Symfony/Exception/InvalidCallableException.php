<?php

namespace Webit\MessageBus\Infrastructure\Symfony\EventDispatcher\Publisher\Event\Symfony\Exception;

class InvalidCallableException extends \InvalidArgumentException
{
    public static function fromCallable($callable): InvalidCallableException
    {
        return new self(sprintf('Given callable "%s" is not valid', self::describeCallable($callable)));
    }

    /**
     * @param mixed $callable
     * @return array|string
     */
    private static function describeCallable($callable)
    {
        if (is_string($callable)) {
            return $callable;
        }

        if (is_array($callable)) {
            if (!$callable) {
                return 'empty array';
            }

            $class = self::describeCallable(array_shift($callable));
            $method = $callable ? self::describeCallable($callable) : '';

            return $method ? sprintf('%s::%s', $class, $method) : $class;
        }

        if (is_object($callable)) {
            return get_class($callable);
        }

        return 'anonymous function';
    }
}
