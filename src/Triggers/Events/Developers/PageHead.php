<?php

namespace Mantiq\Triggers\Events\Developers;

use Mantiq\Models\TriggerEvent;

class PageHead extends TriggerEvent
{
    public function getId()
    {
        return 'wp_head';
    }

    public function getName()
    {
        return __('Page head (scripts and meta tags)', 'mantiq');
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
