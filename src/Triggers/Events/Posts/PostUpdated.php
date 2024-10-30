<?php

namespace Mantiq\Triggers\Events\Posts;

use Mantiq\Models\DataType;
use Mantiq\Models\OutputDefinition;
use Mantiq\Models\TriggerEvent;
use Mantiq\Support\CommonDataTypes;

class PostUpdated extends TriggerEvent
{
    public function getId()
    {
        return 'post_updated';
    }

    public function getName()
    {
        return __('Post updated', 'mantiq');
    }

    public function getGroup()
    {
        return __('Posts', 'mantiq');
    }

    public function getOutputs()
    {
        return [
            new OutputDefinition(
                [
                    'id'   => 'post_id',
                    'name' => __('Post ID', 'mantiq'),
                    'type' => DataType::integer(),
                ]
            ),
            new OutputDefinition(
                [
                    'id'   => 'post_permalink',
                    'name' => __('Post permalink', 'mantiq'),
                    'type' => DataType::string(),
                ]
            ),
            new OutputDefinition(
                [
                    'id'   => 'post_before',
                    'name' => __('Post object (before)', 'mantiq'),
                    'type' => CommonDataTypes::WP_Post(),
                ]
            ),
            new OutputDefinition(
                [
                    'id'   => 'post_after',
                    'name' => __('Post object (after)', 'mantiq'),
                    'type' => CommonDataTypes::WP_Post(),
                ]
            ),
        ];
    }

    public function getNamedArgumentsFromRawEvent($eventArgs)
    {
        return [
            'post_id'        => $eventArgs[0],
            'post_permalink' => get_permalink($eventArgs[0]),
            'post_before'    => $eventArgs[2],
            'post_after'     => $eventArgs[1],
        ];
    }

}
