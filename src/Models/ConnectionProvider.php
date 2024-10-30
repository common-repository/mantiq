<?php

namespace Mantiq\Models;

use Mantiq\Services\ConnectionProvidersRegistry;

abstract class ConnectionProvider implements \JsonSerializable
{
    public function getId()
    {
        return basename(str_replace('\\', '/', static::class));
    }

    public function getName()
    {
        return 'Unnamed action';
    }

    public function toArray()
    {
        return [
            'id'   => $this->getId(),
            'name' => $this->getName(),
        ];
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return $this->toArray();
    }

    public static function register()
    {
        ConnectionProvidersRegistry::instance()->addNewProvider(new static());
    }

    abstract function invoke(ActionInvocationContext $invocation);

}
