<?php

namespace Mantiq\Models;

use Mantiq\Services\ExpressionEngine;
use Mantiq\Support\Collection;

class ActionInvocationContext implements \JsonSerializable
{
    /**
     * @var Action
     */
    public $action;
    /**
     * @var ExecutionContext
     */
    public $context;
    /**
     * @var Node
     */
    public $node;
    /**
     * @var Collection
     */
    public $arguments;

    public function __construct(Action $action, ExecutionContext $context, Node $node)
    {
        $this->action    = $action;
        $this->context   = $context;
        $this->node      = $node;
        $this->arguments = Collection::create($node["properties.arguments.{$action->getId()}"] ?: []);
    }

    public function getEvaluatedArgument($argument, $default = null)
    {
        return $this->getEvaluatedValue($this->arguments->get($argument), $default) ?: $default;
    }

    public function getEvaluatedValue($expression, $default = null)
    {
        return ExpressionEngine::evaluate($expression, $this->context) ?: $default;
    }

    public function getEvaluatedArgumentWithoutEscaping($argument, $default = null)
    {
        return $this->getEvaluatedValueWithoutEscaping($this->arguments->get($argument), $default) ?: $default;
    }

    public function getEvaluatedValueWithoutEscaping($expression, $default = null)
    {
        return ExpressionEngine::evaluateWithoutEscaping($expression, $this->context) ?: $default;
    }

    public function getRawEvaluatedArgument($argument, $default = null)
    {
        return $this->getRawEvaluatedValue($this->arguments->get($argument), $default) ?: $default;
    }

    public function getRawEvaluatedValue($expression, $default = null)
    {
        return ExpressionEngine::rawEvaluate($expression, $this->context) ?: $default;
    }

    public function getRawValueOfArgument($argument, $default = null)
    {
        return $this->getRawValue($this->arguments->get($argument), $default) ?: $default;
    }

    public function getRawValue($expression, $default = null)
    {
        return ExpressionEngine::rawValue($expression, $this->context) ?: $default;
    }

    public function getArgument($argument, $default = null)
    {
        return $this->arguments->get($argument) ?: $default;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        // TODO: Implement jsonSerialize() method.
    }
}
