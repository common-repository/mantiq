<?php

namespace Mantiq\Tasks\Log\Repository;

use Mantiq\Models\LogEntry;
use Mantiq\Plugin;

class CreateLogEntry
{
    public static function invoke($attributes)
    {
        $logTable = Plugin::env('db.tables.log');
        $logData  = [
            'invocation_uid' => $attributes['invocation_uid'],
            'workflow_uid'   => $attributes['workflow_uid'],
            'node_uid'       => $attributes['node_uid'],
            'level'          => $attributes['level'] ?: 'info',
            'message'        => $attributes['message'],
            'context'        => json_encode($attributes['context'] ?? '{}') ?: '{}',
            'logged_at'      => current_time('mysql'),
        ];
        $GLOBALS['wpdb']->insert($logTable, $logData);

        return new LogEntry($logData);
    }
}
