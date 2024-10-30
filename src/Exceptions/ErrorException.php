<?php

namespace Mantiq\Exceptions;

class ErrorException extends \Exception implements \JsonSerializable
{
    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return $this->getMessage();
    }
}
