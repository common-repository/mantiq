<?php

namespace Mantiq\Models;

use Mantiq\Services\TriggersRegistry;
use Mantiq\Support\Arrays;
use Mantiq\Tasks\Workflows\Repository\GetWorkflow;
use Mantiq\Tasks\Workflows\RunWorkflow;

abstract class TriggerEvent extends Model
{
    abstract public function getId();

    abstract public function getName();

    abstract public function getGroup();

    abstract public function getOutputs();

    public function getTemplate()
    {
        return '';
    }

    protected function getTemplateContent()
    {
        if (!file_exists($this->getTemplate())) {
            return '';
        }

        ob_start();

        try {
            include $this->getTemplate();
        } catch (\Exception $exception) {
            printf('<div class="alert">%s</div>', $exception->getMessage());
        }

        return ob_get_clean();
    }
    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return [
            'id'       => $this->getId(),
            'name'     => $this->getName(),
            'group'    => $this->getGroup(),
            'outputs'  => $this->getOutputs(),
            'template' => $this->getTemplateContent(),
        ];
    }

    public static function register()
    {
        $event = new static([]);
        TriggersRegistry::instance()->addNewEvent($event);
    }

    public function getNamedArgumentsFromRawEvent($args)
    {
        $outputsIds = Arrays::extract($this->getOutputs(), 'id');

        if (empty($outputsIds)) {
            return $args;
        }

        $namedArgs = [];
        foreach ($outputsIds as $outputIndex => $outputId) {
            $namedArgs[$outputId] = $args[$outputIndex] ?? null;
        }

        return $namedArgs;
    }

    public function getStartupDefinitionArguments($definition, Workflow $workflow)
    {
        return [];
    }

    public function handleStartupDefinition(StartupDefinition $startupDefinition)
    {
        add_filter(
            $startupDefinition['arguments.hookName'],
            static function (...$args) use ($startupDefinition) {
                return RunWorkflow::invoke(
                    GetWorkflow::invoke($startupDefinition['workflowUid']),
                    ExecutionArguments::fromEvent($startupDefinition, $args)
                );
            },
            $startupDefinition['arguments.hookPriority'] ?? 10,
            999
        );
    }

    public function purgeStartupDefinition(StartupDefinition $startupDefinition)
    {
        wp_clear_scheduled_hook($startupDefinition['arguments.hookName']);
    }
}
