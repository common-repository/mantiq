<?php

namespace Mantiq\Triggers\Events\Users;

use Mantiq\Models\DataType;
use Mantiq\Models\OutputDefinition;
use Mantiq\Models\TriggerEvent;
use Mantiq\Support\CommonDataTypes;

class UserDeleted extends TriggerEvent
{
    public function getId()
    {
        return 'delete_user';
    }

    public function getName()
    {
        return __('User deleted', 'mantiq');
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
                    'id'   => 'reassign',
                    'name' => __('ID of the user to reassign posts and links to.', 'mantiq'),
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
            'user_id'        => $eventArgs[0],
            'user'           => $eventArgs[1],
        ];
    }

}
