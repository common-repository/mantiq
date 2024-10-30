<?php

namespace Mantiq\Http\Repositories;

use Mantiq\Models\Workflow;
use Mantiq\Plugin;
use Mantiq\Services\StartupRegistry;
use Mantiq\Support\Arrays;
use Mantiq\Support\Collection;
use Mantiq\Support\Sql;
use Mantiq\Support\Strings;

class WorkflowsRepository
{
    public static function getWorkflows($args = [])
    {
        $args = Arrays::merge(
            [
                'conditions'     => [],
                'page'           => 1,
                'perPage'        => 30,
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

    public static function getWorkflow($uid)
    {
        $workflows = static::getWorkflows(
            [
                'conditions' => ['uid' => $uid],
                'perPage'    => 1,
            ]
        );

        return $workflows->first();
    }

    public static function updateWorkflow($uid, $attributes)
    {
        $where          = ['uid' => $uid];
        $workflowsTable = Plugin::env('db.tables.workflows');
        $workflowData   = [
            'updated_at'  => current_time('mysql'),
            'enabled'     => (int) ($attributes['enabled'] ?? false),
            'name'        => sanitize_text_field($attributes['name'] ?? 'Untitled'),
            'tree'        => json_encode($attributes['tree'] ?? '{}') ?: '{}',
            'settings' => json_encode($attributes['settings'] ?? '{}') ?: '{}',
            'type'        => $attributes['tree']['properties']['type'],
        ];
        $GLOBALS['wpdb']->update($workflowsTable, $workflowData, $where);

        $workflow = static::getWorkflow($uid);
        StartupRegistry::prepare($workflow);

        return $workflow;
    }

    public static function trashWorkflow($uid)
    {
        $where          = ['uid' => $uid];
        $workflowsTable = Plugin::env('db.tables.workflows');
        $workflowData   = [
            'deleted_at' => current_time('mysql'),
        ];

        return $GLOBALS['wpdb']->update($workflowsTable, $workflowData, $where);
    }

    public static function createWorkflow($attributes)
    {
        $workflowsTable = Plugin::env('db.tables.workflows');
        $workflowData   = [
            'uid'         => $attributes['uid'] ?: Strings::uid(),
            'created_at'  => current_time('mysql'),
            'updated_at'  => current_time('mysql'),
            'enabled'     => (int) ($attributes['enabled'] ?? false),
            'name'        => sanitize_text_field($attributes['name'] ?? 'Untitled'),
            'tree'        => json_encode($attributes['tree'] ?? '{}') ?: '{}',
            'settings' => json_encode($attributes['settings'] ?? '{}') ?: '{}',
            'type'        => $attributes['tree']['properties']['type'],
            'version'     => 1,
        ];
        $GLOBALS['wpdb']->insert($workflowsTable, $workflowData);

        return static::getWorkflow($workflowData['uid']);
    }
}
