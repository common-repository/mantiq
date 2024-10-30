<?php

namespace Mantiq\Concerns;

trait Singleton
{
    protected static $instance = null;

    /**
     * @param ...$args
     *
     * @return static
     */
    public static function instance(...$args)
    {
        if (static::$instance === null) {
            static::$instance = new static(...$args);
        }

        return static::$instance;
    }

    protected function __construct(...$args)
    {
    }
}
