<?php

namespace Mantiq\Tasks\Startup;

use Mantiq\Models\StartupDefinition;
use Mantiq\Models\Workflow;

class PurgeStartupDefinition
{
    public static function invoke(Workflow $workflow, StartupDefinition $startupDefinition)
    {
        if ($startupDefinition->isEvent()) {
            $startupDefinition->getEvent()->purgeStartupDefinition($startupDefinition);
        }

        if ($startupDefinition->isSchedule()) {
            $startupDefinition->getSchedule()->purgeStartupDefinition($startupDefinition);
        }
    }
}
