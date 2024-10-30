<?php

namespace Mantiq\Models;

class DataType extends Model
{

    public static function string()
    {
        return new static(['id' => 'string']);
    }

    public static function integer()
    {
        return new static(['id' => 'integer']);
    }

    public static function float()
    {
        return new static(['id' => 'float']);
    }

    public static function object($properties = [], $descriptor = null)
    {
        return new static(
            ['id' => 'object', 'properties' => $properties]
            + ($descriptor ? ['descriptor' => $descriptor] : [])
        );
    }

    public static function map($properties = [], $descriptor = null)
    {
        return new static(
            ['id' => 'map', 'properties' => $properties]
            + ($descriptor ? ['descriptor' => $descriptor] : [])
        );
    }

    public static function array($properties = [], $descriptor = null)
    {
        return new static(
            ['id' => 'array', 'properties' => $properties]
            + ($descriptor ? ['descriptor' => $descriptor] : [])
        );
    }

    public static function listOf($values, $descriptor = null)
    {
        return new static(['id' => 'list', 'values' => $values]);
    }

    public static function boolean()
    {
        return new static(['id' => 'boolean']);
    }
}
