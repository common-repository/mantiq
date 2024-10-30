<?php

namespace Mantiq\Tasks\Workflows\Repository;

use Mantiq\Models\Workflow;
use Mantiq\Plugin;
use Mantiq\Support\Arrays;
use Mantiq\Support\Collection;
use Mantiq\Support\Sql;

class GetWorkflows
{
    public static function invoke($args = [])
    {
        $args = Arrays::merge(
            [
                'conditions'     => [],
                'page'           => 1,
                'perPage'        => 99,
                'orderBy'        => 'created_at',
                'orderDirection' => 'DESC',
            ],
            $args
        );

        $where          = Sql::generateWhereClause($args['conditions']);
        $where          = ($where ? $where.'AND ' : 'WHERE ').'deleted_at IS NULL';
        $orderBy        = Sql::generateOrderClause($args['orderBy'], $args['orderDirection']);
        $limit          = $args['perPage'] === -1 ? '' : Sql::generateLimitClause($args['page'], $args['perPage']);
        $workflowsTable = Plugin::env('db.tables.workflows');

        $query  = "SELECT * FROM $workflowsTable $where $orderBy $limit";
        $items  = $GLOBALS['wpdb']->get_results($query, ARRAY_A);
        $models = Collection::create();

        foreach ($items as $item) {
            $models[] = new Workflow($item);
        }

        return $models;
    }
}
