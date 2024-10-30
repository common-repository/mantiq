<?php

namespace Mantiq\Tasks\Workflows\Repository;

use Mantiq\Plugin;

class UpdateWorkflowLastRun
{
    public static function invoke($uid)
    {
        $where          = ['uid' => $uid];
        $workflowsTable = Plugin::env('db.tables.workflows');
        $workflowData   = [
            'last_run_at' => current_time('mysql'),
        ];
        $GLOBALS['wpdb']->update($workflowsTable, $workflowData, $where);
    }

}
