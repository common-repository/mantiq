<?php

namespace Mantiq\Triggers\Events\Users;

use Mantiq\Models\DataType;
use Mantiq\Models\OutputDefinition;
use Mantiq\Models\TriggerEvent;
use Mantiq\Support\CommonDataTypes;

class UserLoggedIn extends TriggerEvent
{
    public function getId()
    {
        return 'wp_login';
    }

    public function getName()
    {
        return __('User logged in', 'mantiq');
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
                    'id'   => 'user_login',
                    'name' => __('Username', 'mantiq'),
                    'type' => DataType::string(),
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
            'user'    => $eventArgs[1],
        ];
    }
}
