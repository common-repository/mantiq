<?php

namespace Mantiq\Actions\Developers;

use Mantiq\Models\Action;
use Mantiq\Models\ActionInvocationContext;
use Mantiq\Plugin;
use Mantiq\Services\WorkflowLogger;

class WriteToLog extends Action
{
    public function getName()
    {
        return __('Write to log', 'mantiq');
    }

    public function getDescription()
    {
        return __('Write content to the log.', 'mantiq');
    }

    public function getGroup()
    {
        return __('Developers - Utilities', 'mantiq');
    }

    public function getOutputs()
    {
        return [];
    }

    public function getTemplate()
    {
        return Plugin::getPath('editor/views/actions/developers/write-to-log.php');
    }

    function invoke(ActionInvocationContext $invocation)
    {
        return WorkflowLogger::write(
            $invocation->context->uid,
            $invocation->context->workflow->uid,
            $invocation->node->uid,
            $invocation->getEvaluatedArgumentWithoutEscaping('content'),
            $invocation->getEvaluatedArgumentWithoutEscaping('context'),
            $invocation->getArgument('level', 'info')
        );
    }
}
