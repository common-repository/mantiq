<?php

namespace Mantiq\Tasks\Connections\Repository;

use Mantiq\Services\ConnectionsStore;

class SaveConnection
{
    public static function invoke($attributes)
    {
        return ConnectionsStore::instance()->save($attributes['provider'], $attributes['connection']);
    }

}
