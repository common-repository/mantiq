<?php

namespace Mantiq\Tasks\Workflows\Repository;

use Mantiq\Plugin;

class RecoverWorkflow
{
    public static function invoke($uid)
    {
        $where          = ['uid' => $uid];
        $workflowsTable = Plugin::env('db.tables.workflows');
        $workflowData   = [
            'deleted_at' => null,
        ];

        return $GLOBALS['wpdb']->update($workflowsTable, $workflowData, $where);
    }

}
