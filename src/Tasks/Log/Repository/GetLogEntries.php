<?php

namespace Mantiq\Tasks\Log\Repository;

use Mantiq\Models\LogEntry;
use Mantiq\Plugin;
use Mantiq\Support\Arrays;
use Mantiq\Support\Collection;
use Mantiq\Support\Sql;

class GetLogEntries
{
    public static function invoke($args = [])
    {
        $args = Arrays::merge(
            [
                'conditions'     => [],
                'page'           => 1,
                'perPage'        => 99,
                'orderBy'        => 'logged_at',
                'orderDirection' => 'DESC',
            ],
            $args
        );

        $where    = Sql::generateWhereClause($args['conditions']);
        $orderBy  = Sql::generateOrderClause($args['orderBy'], $args['orderDirection']);
        $limit    = $args['perPage'] === -1 ? '' : Sql::generateLimitClause($args['page'], $args['perPage']);
        $logTable = Plugin::env('db.tables.log');

        $query  = "SELECT * FROM $logTable $where $orderBy $limit";
        $items  = $GLOBALS['wpdb']->get_results($query, ARRAY_A);
        $models = Collection::create();

        foreach ($items as $item) {
            $models[] = new LogEntry($item);
        }

        return $models;
    }
}
