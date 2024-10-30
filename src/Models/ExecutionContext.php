<?php

namespace Mantiq\Models;

use Mantiq\Services\ExpressionEngine;
use Mantiq\Support\Strings;
use Mantiq\Tasks\Workflows\GetGlobals;

/**
 * @property Workflow $workflow
 * @property string uid
 */
class ExecutionContext extends Model
{
    public static function create(Workflow $workflow, ExecutionArguments $args)
    {
        return new self([
                            'uid'         => Strings::uid(),
                            'trigger'     => [],
                            'assignments' => [],
                            'globals'     => GetGlobals::invoke(),
                            'actions'     => [],
                            'meta'        => [],
                            'workflow'    => $workflow,
                            'arguments'   => $args,
                        ]);
    }

    public function log($message, $level)
    {
    }

    public function output($node, $value)
    {
        $this['output'] = $value;

        return $this['output'];
    }

    public function assign($variableId, $value)
    {
        $this["assignments.{$variableId}"] = ExpressionEngine::evaluate(
            trim($value),
            $this
        );

        return $this["assignments.{$variableId}"];
    }

    public function condition($condition)
    {
        $source = ExpressionEngine::evaluate($condition['source'], $this);
        $value  = ExpressionEngine::evaluate($condition['value'], $this);

        $conditionContext = [
            'source' => $source,
            'value'  => $value,
        ];

        $conditionExpression = '';

        switch ($condition['operator']) {
            case 'equal':
                $conditionExpression = "source == value";
                break;
            case 'notEqual':
                $conditionExpression = "source != value";
                break;
            case 'greaterThan':
                $conditionExpression = "source > value";
                break;
            case 'greaterThanOrEqual':
                $conditionExpression = "source >= value";
                break;
            case 'lowerThan':
                $conditionExpression = "source < value";
                break;
            case 'lowerThanOrEqual':
                $conditionExpression = "source <= value";
                break;
            case 'empty':
                $conditionExpression = "source == ''";
                break;
            case 'notEmpty':
                $conditionExpression = "source != ''";
                break;
            case 'in':
                $conditionExpression = "source in value";
                break;
            default:
                $conditionExpression = "source == ''";
        }

        return ExpressionEngine::rawEvaluate(
            $conditionExpression,
            $conditionContext
        );
    }

    public function conditions($conditions, $order)
    {
        $expression = preg_replace_callback(
            "/(?P<ref>(\d))/",
            static function ($matches) use ($conditions) {
                return ($conditions[$matches['ref']] ?? false) ? 'true' : 'false';
            },
            $order
        );

        return empty($expression) ? false : ExpressionEngine::rawEvaluate($expression);
    }

    public function action($refId, $nodeUid, $value)
    {
        $this["actions.{$nodeUid}"] = $this["actions.{$refId}"] = $value;

        return $value;
    }

    public function trigger($value)
    {
        return $this['trigger'] = $value;
    }

    public function toPublic()
    {
        if ($this->workflow->isDebuggingEnabled()) {
            return $this->attributes->set('__NOTICE__', __('You are seeing this detailed view because the debugging mode is activated.', 'mantiq'));
        }

        return [
            'success' => true,
            'uid'     => $this->attributes['uid'],
        ];
    }
}
