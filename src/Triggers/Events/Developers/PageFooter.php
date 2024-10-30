<?php

namespace Mantiq\Triggers\Events\Developers;

use Mantiq\Models\TriggerEvent;

class PageFooter extends TriggerEvent
{
    public function getId()
    {
        return 'wp_footer';
    }

    public function getName()
    {
        return __('Footer', 'mantiq');
    }

    public function getGroup()
    {
        return __('Developers - Frontend', 'mantiq');
    }

    public function getOutputs()
    {
        return [
        ];
    }

    public function getNamedArgumentsFromRawEvent($eventArgs)
    {
        return [];
    }

}
