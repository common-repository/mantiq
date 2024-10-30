<?php

namespace Mantiq\Tasks\Log\Repository;

use Mantiq\Plugin;
use Mantiq\Support\Arrays;
use Mantiq\Support\Sql;

class DeleteLogEntries
{
    public static function invoke($args = [])
    {
        $args = Arrays::merge(
            [
                'conditions' => [],
            ],
            $args
        );

        $where    = Sql::generateWhereClause($args['conditions']);
        $logTable = Plugin::env('db.tables.log');

        $query = "DELETE FROM $logTable $where";

        return $GLOBALS['wpdb']->query($query, ARRAY_A);
    }
}
