<?php

namespace Mantiq\Tasks\Workflows;

use Mantiq\Models\Workflow;

class SetupWorkflowTrigger
{
    public static function invoke(Workflow $workflow)
    {
        static::cleanup($workflow);

        if ($workflow->isSchedule()) {
            static::prepareSchedule($workflow);
        }

        if ($workflow->isWebhook()) {
            static::prepareWebhook($workflow);
        }

        if ($workflow->isEvent()) {
            static::prepareEvent($workflow);
        }
    }

    protected static function prepareSchedule(Workflow $workflow)
    {
        wp_clear_scheduled_hook($workflow->getScheduleHookName());

        $currentTime = current_time('timestamp', true);
        $startAt     = strtotime($workflow['tree.properties.arguments.schedule.startDate']) ?: $currentTime;
        $frequency   = $workflow['tree.properties.arguments.schedule.frequency'];

        if ($startAt <= $currentTime) {
            $schedule = wp_get_schedules()[$frequency];
            $startAt  += $schedule['interval'];
        }

        wp_schedule_event($startAt, $frequency, $workflow->getScheduleHookName());
    }

    protected static function prepareWebhook(Workflow $workflow)
    {
    }

    protected static function prepareEvent(Workflow $workflow)
    {
    }

    protected static function cleanup(Workflow $workflow)
    {
        wp_clear_scheduled_hook($workflow->getScheduleHookName());
    }
}
