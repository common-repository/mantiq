<?php

namespace Mantiq\Tasks\Startup;

use Mantiq\Models\StartupDefinition;
use Mantiq\Models\Workflow;
use Mantiq\Services\FormProvidersRegistry;
use Mantiq\Services\TriggersRegistry;

class ExtractStartupDefinition
{
    public static function invoke(Workflow $workflow)
    {
        // Extraction
        $attributes = [];
        if ($workflow->isSchedule()) {
            $attributes = static::prepareSchedule($workflow);
        }

        if ($workflow->isWebhook()) {
            $attributes = static::prepareWebhook($workflow);
        }

        if ($workflow->isEvent()) {
            $attributes = static::prepareEvent($workflow);
        }

        if ($workflow->isForm()) {
            $attributes = static::prepareForm($workflow);
        }

        return new StartupDefinition($attributes);
    }

    /**
     * @throws \Exception
     */
    protected static function prepareSchedule(Workflow $workflow)
    {
        $currentTime = current_time('timestamp', true);
        $startAt     = strtotime($workflow['tree.properties.arguments.schedule.startDate']) ?: $currentTime;
        $frequency   = $workflow['tree.properties.arguments.schedule.frequency'];

        if ($startAt <= $currentTime) {
            $schedule = wp_get_schedules()[$frequency];
            $startAt  = $currentTime + ($schedule['interval'] - (($currentTime - $startAt) % $schedule['interval']));
        }

        return [
            'workflowUid' => $workflow->uid,
            'type'        => Workflow::SCHEDULE,
            'arguments'   => [
                'startAt'    => $startAt,
                'frequency'  => $frequency,
                'scheduleId' => $workflow->getScheduleId(),
                'hookName'   => $workflow->getScheduleHookName(),
            ],
        ];
    }

    protected static function prepareWebhook(Workflow $workflow)
    {
        return [
            'workflowUid' => $workflow->uid,
            'type'        => Workflow::WEBHOOK,
            'arguments'   => [
                'route'      => "webhook/execute/{$workflow->getWebhookSlug()}",
                'parameters' => $workflow->getWebhookParameters(),
                'hookName'   => $workflow->getWebhookHookName(),
            ],
        ];
    }

    protected static function prepareEvent(Workflow $workflow)
    {
        $definition = [
            'workflowUid' => $workflow->uid,
            'type'        => Workflow::EVENT,
            'arguments'   => [
                'eventId'  => $workflow->getEventId(),
                'hookName' => $workflow->getEventHookName(),
            ],
        ];

        $event                   = TriggersRegistry::instance()->getEvent($workflow->getEventId());
        $definition['arguments'] = array_merge(
            $definition['arguments'],
            $event->getStartupDefinitionArguments($definition, $workflow)
        );

        return $definition;
    }

    protected static function prepareForm(Workflow $workflow)
    {
        $definition = [
            'workflowUid' => $workflow->uid,
            'type'        => Workflow::FORM,
            'arguments'   => [
                'formUid'        => $workflow->getFormUid(),
                'formId'         => $workflow->getFormId(),
                'formProviderId' => $workflow->getFormProviderId(),
            ],
        ];

        $formProvider = FormProvidersRegistry::get($workflow->getFormProviderId());

        if ($formProvider) {
            $definition['arguments'] = array_merge(
                $definition['arguments'],
                $formProvider->getStartupDefinitionArguments($definition, $workflow)
            );
        }

        return $definition;
    }

}
