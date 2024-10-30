<?php

namespace Mantiq\Tasks\Workflows\Repository;

use Mantiq\Plugin;
use Mantiq\Services\WorkflowLogger;
use Mantiq\Support\Strings;

class CreateWorkflow
{
    public static function invoke($attributes)
    {
        $workflowsTable = Plugin::env('db.tables.workflows');
        $workflowData   = [
            'uid'        => $attributes['uid'] ?: Strings::uid(),
            'created_at' => current_time('mysql'),
            'updated_at' => current_time('mysql'),
            'enabled'    => (int) ($attributes['enabled'] ?? false),
            'name'       => sanitize_text_field($attributes['name'] ?? 'Untitled'),
            'tree'       => json_encode($attributes['tree'] ?? '{}') ?: '{}',
            'settings'   => json_encode($attributes['settings'] ?? '{}') ?: '{}',
            'type'       => $attributes['tree']['properties']['type'],
            'version'    => 1,
        ];
        $GLOBALS['wpdb']->insert($workflowsTable, $workflowData);

        WorkflowLogger::queueWrite(null, $workflowData['uid'], null, 'Workflow created');

        return GetWorkflow::invoke($workflowData['uid']);
    }
}
