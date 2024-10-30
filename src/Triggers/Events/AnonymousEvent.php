<?php

namespace Mantiq\Triggers\Events;

use Mantiq\Models\TriggerEvent;

class AnonymousEvent extends TriggerEvent
{
    public function getId()
    {
        return $this->attributes['id'] ?? 'anonymous';
    }

    public function getName()
    {
        return $this->attributes['name'] ?? __('Anonymous event', 'mantiq');
    }

    public function getGroup()
    {
        return $this->attributes['group'] ?? __('Anonymous', 'mantiq');
    }

    public function getOutputs()
    {
        return $this->attributes['outputs'] ?? [];
    }

    public function getNamedArgumentsFromRawEvent($eventArgs)
    {
        return [];
    }
}
