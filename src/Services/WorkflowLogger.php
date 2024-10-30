<?php

namespace Mantiq\Services;

use Mantiq\Concerns\Singleton;
use Mantiq\Support\Collection;
use Mantiq\Tasks\Log\Repository\CreateLogEntry;

class WorkflowLogger
{
    use Singleton;

    /**
     * @var Collection
     */
    protected $queue;

    public function __construct()
    {
        $this->queue = Collection::create();

        add_action('shutdown', function () {
            while (!$this->queue->isEmpty()) {
                $log = $this->queue->shift();
                CreateLogEntry::invoke($log);
            }
        });
    }

    public static function queueWrite($invocationUid, $workflowUid, $nodeUid, $message, $context = [], $level = 'info')
    {
        return self::instance()->queueLog($invocationUid, $workflowUid, $nodeUid, $message, $context, $level);
    }

    public static function write($invocationUid, $workflowUid, $nodeUid, $message, $context = [], $level = 'info')
    {
        return self::instance()->log($invocationUid, $workflowUid, $nodeUid, $message, $context, $level);
    }

    /**
     * @param $invocationUid
     * @param $workflowUid
     * @param $nodeUid
     * @param $message
     * @param  array  $context
     * @param  string  $level
     *
     * @return array
     */
    public function queueLog($invocationUid, $workflowUid, $nodeUid, $message, $context = [], $level = 'info')
    {
        $model = [
            'invocation_uid' => $invocationUid,
            'workflow_uid'   => $workflowUid,
            'node_uid'       => $nodeUid,
            'message'        => $message,
            'level'          => $level,
            'context'        => $context,
        ];
        $this->queue->push($model);

        return $model;
    }

    /**
     * @param $invocationUid
     * @param $workflowUid
     * @param $nodeUid
     * @param $message
     * @param  array  $context
     * @param  string  $level
     *
     * @return \Mantiq\Models\LogEntry
     */
    public function log($invocationUid, $workflowUid, $nodeUid, $message, $context = [], $level = 'info')
    {
        $model = [
            'invocation_uid' => $invocationUid,
            'workflow_uid'   => $workflowUid,
            'node_uid'       => $nodeUid,
            'message'        => $message,
            'level'          => $level,
            'context'        => $context,
        ];

        return CreateLogEntry::invoke($model);
    }

}
