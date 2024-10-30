<?php

namespace Mantiq\Models;


use Mantiq\Services\FormProvidersRegistry;
use Mantiq\Services\TriggersRegistry;

class StartupDefinition extends Model
{
    public function isEvent()
    {
        return $this->type === Workflow::EVENT;
    }

    public function isWebhook()
    {
        return $this->type === Workflow::WEBHOOK;
    }

    public function isSchedule()
    {
        return $this->type === Workflow::SCHEDULE;
    }

    public function isForm()
    {
        return $this->type === Workflow::FORM;
    }

    public function getEvent()
    {
        return TriggersRegistry::instance()->getEvent($this['arguments.eventId'] ?? $this['arguments.hookName']);
    }

    public function getSchedule()
    {
        return TriggersRegistry::instance()->getSchedule($this['arguments.scheduleId'] ?? $this['arguments.frequency']);
    }

    public function getFormProvider()
    {
        return FormProvidersRegistry::get($this['arguments.formProviderId']);
    }
}
