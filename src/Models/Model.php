<?php

namespace Mantiq\Models;

use Mantiq\Support\Collection;

class Model implements \ArrayAccess, \JsonSerializable
{
    public $attributes = [];

    public function __construct($rawAttributes)
    {
        $attributes       = $this->fromDatabase($rawAttributes);
        $this->attributes = Collection::create($attributes);
        $this->bootstrap();
    }

    public function bootstrap()
    {

    }

    #[\ReturnTypeWillChange]
    public function offsetExists($offset)
    {
        return $this->attributes->has($offset);
    }

    #[\ReturnTypeWillChange]
    public function offsetGet($offset)
    {
        return $this->attributes->get($offset);
    }

    #[\ReturnTypeWillChange]
    public function offsetSet($offset, $value)
    {
        return $this->attributes->set($offset, $value);
    }

    #[\ReturnTypeWillChange]
    public function offsetUnset($offset)
    {
        return $this->attributes->forget($offset);
    }

    public function __get($name)
    {
        return $this->offsetGet($name);
    }

    public function __set($name, $value)
    {
        $this->offsetSet($name, $value);
    }

    public function __isset($name)
    {
        return $this->offsetExists($name);
    }
    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return $this->attributes->toArray();
    }

    public function fromDatabase($rawAttributes)
    {
        return $rawAttributes;
    }

    public function toArray()
    {
        return $this->attributes->toArray();
    }

    public function toDatabase($rawAttributes)
    {
        return $this->attributes;
    }
}
