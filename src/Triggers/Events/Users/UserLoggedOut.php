<?php

namespace Mantiq\Triggers\Events\Users;

use Mantiq\Models\DataType;
use Mantiq\Models\OutputDefinition;
use Mantiq\Models\TriggerEvent;
use Mantiq\Support\CommonDataTypes;

class UserLoggedOut extends TriggerEvent
{
    public function getId()
    {
        return 'wp_logout';
    }

    public function getName()
    {
        return __('User logged out', 'mantiq');
    }

    public function getGroup()
    {
        return __('Users', 'mantiq');
    }

    public function getOutputs()
    {
        return [
            new OutputDefinition(
                [
                    'id'   => 'user_id',
                    'name' => __('User ID', 'mantiq'),
                    'type' => DataType::integer(),
                ]
            ),
            new OutputDefinition(
                [
                    'id'   => 'user',
                    'name' => __('User object', 'mantiq'),
                    'type' => CommonDataTypes::WP_User(),
                ]
            ),
        ];
    }

    public function getNamedArgumentsFromRawEvent($eventArgs)
    {
        return [
            'user_id' => $eventArgs[0],
            'user'    => get_userdata($eventArgs[0]),
        ];
    }
}
