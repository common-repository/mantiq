<?php

namespace Mantiq\Tasks\Workflows\Repository;

use Mantiq\Plugin;
use Mantiq\Services\StartupRegistry;
use Mantiq\Services\WorkflowLogger;

class TrashWorkflow
{
    public static function invoke($uid)
    {
        $where          = ['uid' => $uid];
        $workflowsTable = Plugin::env('db.tables.workflows');
        $workflowData   = [
            'enabled'    => 0,
            'deleted_at' => current_time('mysql'),
        ];

        $workflow = GetWorkflow::invoke($uid);

        WorkflowLogger::queueWrite(null, $uid, null, 'Workflow trashed');

        StartupRegistry::instance()->deregister($workflow);

        return (boolean) $GLOBALS['wpdb']->update($workflowsTable, $workflowData, $where);
    }

}
