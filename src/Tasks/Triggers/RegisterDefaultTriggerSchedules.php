<?php

namespace Mantiq\Tasks\Triggers;

use Mantiq\Models\TriggerSchedule;
use Mantiq\Services\TriggersRegistry;

class RegisterDefaultTriggerSchedules
{
    public static function invoke()
    {
        $registry = TriggersRegistry::instance();

        $registry->addNewSchedule(
            new TriggerSchedule(
                [
                    'id'   => 'hourly',
                    'name' => __('Hourly', 'mantiq'),
                ]
            )
        );

        $registry->addNewSchedule(
            new TriggerSchedule(
                [
                    'id'   => 'daily',
                    'name' => __('Daily', 'mantiq'),
                ]
            )
        );

        $registry->addNewSchedule(
            new TriggerSchedule(
                [
                    'id'   => 'weekly',
                    'name' => __('Weekly', 'mantiq'),
                ]
            )
        );

        $registry->addNewSchedule(
            new TriggerSchedule(
                [
                    'id'   => 'monthly',
                    'name' => __('Monthly', 'mantiq'),
                ]
            )
        );

        add_filter('cron_schedules', function ($schedules) {
            $schedules['minutely'] = [
                'interval' => 60,
                'display'  => esc_html__('Every Five Seconds'),
            ];

            return $schedules;
        });


        $registry->addNewSchedule(
            new TriggerSchedule(
                [
                    'id'   => 'minutely',
                    'name' => __('Minutely', 'mantiq'),
                ]
            )
        );
    }
}
