<?php

namespace Mantiq\Models;

use Mantiq\Tasks\Workflows\Repository\GetWorkflow;
use Mantiq\Tasks\Workflows\RunWorkflow;

class TriggerSchedule extends Model
{
    public function handleStartupDefinition(StartupDefinition $startupDefinition)
    {
        if (!wp_next_scheduled($startupDefinition['arguments.hookName'])) {
            wp_schedule_event(
                $startupDefinition['arguments.startAt'],
                $startupDefinition['arguments.frequency'],
                $startupDefinition['arguments.hookName']
            );
        }

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
