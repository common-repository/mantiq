<?php

namespace Mantiq\Tasks\Workflows;

use Mantiq\Actions\VoidAction;
use Mantiq\Exceptions\ErrorException;
use Mantiq\Models\ActionInvocationContext;
use Mantiq\Models\ExecutionContext;
use Mantiq\Models\Node;
use Mantiq\Services\ActionsRegistry;
use Mantiq\Services\WorkflowLogger;

class ProcessNode
{
    public static function invoke(Node $node, ExecutionContext $context)
    {
        $output = null;
        try {
            if ($node->isTrigger()) {
                $context->output($node, static::trigger($node, $context));
            } elseif ($node->isAssign()) {
                // Assignment
                $context->output($node, static::assign($node, $context));
            } elseif ($node->isCondition()) {
                // Condition
                $node = static::condition($node, $context);
            } elseif ($node->isAction()) {
                // Action
                $context->output($node, static::action($node, $context));
            }

            // Subtree
            foreach ($node->children as $subNode) {
                $context->output($node, static::invoke($subNode, $context));
            }
        } catch (\Exception $exception) {
            WorkflowLogger::queueWrite(
                $context->uid,
                $context->workflow->uid,
                $node->uid,
                "Exception thrown during the execution of {$node->type}: {$exception->getMessage()}",
                ['trace' => $exception->getTraceAsString()],
                'error'
            );

            throw $exception;
        }

        if (!empty($context['output']['error']) && $context['output']['error'] instanceof \Exception) {
            WorkflowLogger::queueWrite(
                $context->uid,
                $context->workflow->uid,
                $node->uid,
                $context['output']['error']->getMessage(),
                [],
                'error'
            );
        }

        return $context['output'];
    }

    protected static function assign(Node $node, ExecutionContext $context)
    {
        foreach ($node['properties']['variables'] as $variableId => $variable) {
            $context->assign($variableId, $variable['value']);
        }

        WorkflowLogger::queueWrite(
            $context->uid,
            $context->workflow->uid,
            $node->uid,
            "Processing assignment node: ".implode(', ', array_keys($node['properties']['variables']))
        );

        return null;
    }

    protected static function condition(Node $node, ExecutionContext $context)
    {
        $defaultBranch = $node->children[0];
        $branches      = $node->children->slice(1)->toArray();

        foreach ($branches as $branchIndex => $branch) {
            $branchName       = $branch['properties.name'] ?: "Branch #".($branchIndex + 1);
            $conditions       = $branch['properties.conditions'] ?: [];
            $conditionsOutput = [];

            foreach ($conditions as $conditionIndex => $condition) {
                $conditionsOutput[$conditionIndex + 1] = $context->condition($condition);

                WorkflowLogger::queueWrite(
                    $context->uid,
                    $context->workflow->uid,
                    $node->uid,
                    "Processing condition node ($branchName - condition #".($conditionIndex + 1)."): ".($conditionsOutput[$conditionIndex + 1] ? 'true' : 'false')
                );
            }

            $evaluationOrder = strtolower($branch['properties.evaluationOrder']) ?: implode(
                ' && ',
                array_keys(
                    $conditionsOutput
                )
            );

            if ($context->conditions($conditionsOutput, $evaluationOrder)) {
                WorkflowLogger::queueWrite(
                    $context->uid,
                    $context->workflow->uid,
                    $node->uid,
                    "Processing condition node ($branchName - evaluation order: $evaluationOrder): true"
                );

                return $branch;
            }

            WorkflowLogger::queueWrite(
                $context->uid,
                $context->workflow->uid,
                $node->uid,
                "Processing condition node ($branchName - evaluation order: $evaluationOrder): false"
            );
        }

        return $defaultBranch;
    }

    protected static function action(Node $node, ExecutionContext $context)
    {
        $action = ActionsRegistry::get($node['properties.id']);

        if ($action instanceof VoidAction) {
            throw new ErrorException(sprintf("Action (%s) could not be found", $node['properties.id']));
        }

        $refId = $node['properties.name'] ?: $node->uid;

        WorkflowLogger::queueWrite(
            $context->uid,
            $context->workflow->uid,
            $node->uid,
            "Processing action node ({$action->getName()}): $refId"
        );
        $actionOutput = $action->invoke(new ActionInvocationContext($action, $context, $node));

        return $context->action($refId, $node->uid, $actionOutput);
    }

    protected static function trigger(Node $node, ExecutionContext $context)
    {
        WorkflowLogger::queueWrite($context->uid, $context->workflow->uid, $node->uid, 'Processing trigger node');

        $context->trigger($context['arguments']);

        return true;
    }
}
