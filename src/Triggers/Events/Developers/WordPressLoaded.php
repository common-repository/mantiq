<?php

namespace Mantiq\Triggers\Events\Developers;

use Mantiq\Models\TriggerEvent;

class WordPressLoaded extends TriggerEvent
{
    public function getId()
    {
        return 'wp_loaded';
    }

    public function getName()
    {
        return __('WordPress loaded', 'mantiq');
    }

    public function getGroup()
    {
        return __('Developers - Frontend', 'mantiq');
    }

    public function getOutputs()
    {
        return [];
    }

    public function getNamedArgumentsFromRawEvent($eventArgs)
    {
        return [];
    }

}
