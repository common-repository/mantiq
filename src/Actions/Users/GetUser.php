<?php

namespace Mantiq\Actions\Users;

use Mantiq\Models\Action;
use Mantiq\Models\ActionInvocationContext;
use Mantiq\Models\DataType;
use Mantiq\Models\OutputDefinition;
use Mantiq\Plugin;
use Mantiq\Support\CommonDataTypes;

class GetUser extends Action
{
    public function getName()
    {
        return __('Get user', 'mantiq');
    }

    public function getDescription()
    {
        return __('Get a generic user.', 'mantiq');
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
                    'id'          => 'success',
                    'name'        => __('Operation state', 'mantiq'),
                    'description' => __('Whether the operation succeeded or not.', 'mantiq'),
                    'type'        => DataType::boolean(),
                ]
            ),
            new OutputDefinition(
                [
                    'id'          => 'user_id',
                    'name'        => __('User ID', 'mantiq'),
                    'description' => __('The ID of the of the retrieved user.', 'mantiq'),
                    'type'        => DataType::integer(),
                ]
            ),
            new OutputDefinition(
                [
                    'id'          => 'user',
                    'name'        => __('User Object', 'mantiq'),
                    'description' => __('The user object (WP_User).', 'mantiq'),
                    'type'        => CommonDataTypes::WP_User(),
                ]
            ),
        ];
    }

    public function getTemplate()
    {
        return Plugin::getPath('editor/views/actions/users/get-user.php');
    }

    public function invoke(ActionInvocationContext $invocation)
    {
        $rawUserId = $invocation->getEvaluatedArgument('id');

        if (is_numeric($rawUserId)) {
            $userId = (int) $rawUserId;
        } elseif (is_email($rawUserId)) {
            $userId = get_user_by('email', $rawUserId)->ID;
        } elseif (!empty($rawUserId)) {
            $userId = get_user_by('login', $rawUserId)->ID;
        } else {
            return [
                'success' => false,
                'error'   => new \Exception("The user ID has not been provided."),
            ];
        }

        $customArguments = json_decode($invocation->getEvaluatedArgument('customArguments', '{}'), true);
        $userArguments   = array_merge(['ID' => $userId, 'users_per_page' => 1], $customArguments ?: []);

        $user = get_user_by('id', $userArguments['ID']);

        if (!$user instanceof \WP_User) {
            return [
                'success' => false,
                'error'   => new \Exception("The user could not be retrieved"),
                'user_id' => 0,
                'user'    => [],
            ];
        }

        return [
            'success' => true,
            'user_id' => $user->ID,
            'user'    => $user->to_array(),
        ];
    }
}
