<?php

namespace Mantiq\Tasks\Workflows\Repository;

use Mantiq\Plugin;
use Mantiq\Services\StartupRegistry;
use Mantiq\Services\WorkflowLogger;

class UpdateWorkflow
{
    public static function invoke($uid, $attributes)
    {
        $where          = ['uid' => $uid];
        $workflowsTable = Plugin::env('db.tables.workflows');
        $workflowData   = [
            'updated_at' => current_time('mysql'),
            'enabled'    => (int) ($attributes['enabled'] ?? false),
            'name'       => sanitize_text_field($attributes['name'] ?? 'Untitled'),
            'tree'       => json_encode($attributes['tree'] ?? '{}') ?: '{}',
            'settings'   => json_encode($attributes['settings'] ?? '{}') ?: '{}',
            'type'       => $attributes['tree']['properties']['type'],
        ];
        $GLOBALS['wpdb']->update($workflowsTable, $workflowData, $where);

        WorkflowLogger::queueWrite(null, $uid, null, 'Workflow updated');

        $workflow = GetWorkflow::invoke($uid);

        StartupRegistry::instance()->register($workflow);

        return $workflow;
    }

}
