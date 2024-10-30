<?php

namespace Mantiq\Tasks\Workflows;

use Mantiq\Models\ExecutionArguments;
use Mantiq\Models\ExecutionContext;
use Mantiq\Models\Workflow;
use Mantiq\Services\WorkflowLogger;
use Mantiq\Tasks\Workflows\Repository\UpdateWorkflowLastRun;

class RunWorkflow
{
    /**
     * @param  Workflow  $workflow
     * @param  ExecutionArguments  $args
     *
     * @return ExecutionContext
     */
    public static function invoke(Workflow $workflow, ExecutionArguments $args)
    {
        $context = ExecutionContext::create($workflow, $args);

        WorkflowLogger::queueWrite(null, $workflow->uid, null, 'Workflow context initialized');

        try {
            ProcessNode::invoke($workflow['tree'], $context);
            UpdateWorkflowLastRun::invoke($workflow['uid']);
        } catch (\Exception $exception) {
            $context['error']  = $exception->getMessage();
            $context['output'] = null;
        }

        return $context;
    }
}
