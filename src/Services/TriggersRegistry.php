<?php

namespace Mantiq\Services;

use Mantiq\Concerns\Singleton;
use Mantiq\Models\TriggerEvent;
use Mantiq\Models\TriggerSchedule;
use Mantiq\Support\Collection;
use Mantiq\Triggers\Events\AnonymousEvent;

class TriggersRegistry
{
    use Singleton;

    /**
     * @var Collection<TriggerSchedule>|TriggerSchedule[]
     */
    protected $schedules;

    /**
     * @var Collection<TriggerEvent>|TriggerEvent[]
     */
    protected $events;

    public function __construct()
    {
        $this->schedules = Collection::create();
        $this->events    = Collection::create();
    }

    public function addNewSchedule(TriggerSchedule $schedule)
    {
        $this->schedules->set($schedule['id'], $schedule);
    }

    public function addNewEvent(TriggerEvent $event)
    {
        $this->events->set($event->getId(), $event);
    }

    public function toArray()
    {
        return [
            'events'    => $this->events->toArray(),
            'forms'     => FormProvidersRegistry::instance()->getFormTriggers(),
            'schedules' => $this->schedules->toArray(),
        ];
    }

    /**
     * @param $id
     *
     * @return TriggerEvent
     */
    public function getEvent($id)
    {
        return $this->events->get($id) ?? new AnonymousEvent(['id' => $id]);
    }

    /**
     * @param $id
     *
     * @return TriggerSchedule
     */
    public function getSchedule($id)
    {
        return $this->schedules->get($id) ?? new TriggerSchedule(['id' => $id]);
    }
}
