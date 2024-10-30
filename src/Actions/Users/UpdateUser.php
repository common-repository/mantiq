<?php

namespace Mantiq\Actions\Users;

use Mantiq\Models\Action;
use Mantiq\Models\ActionInvocationContext;
use Mantiq\Models\DataType;
use Mantiq\Models\OutputDefinition;
use Mantiq\Plugin;
use Mantiq\Support\CommonDataTypes;

class UpdateUser extends Action
{
    public function getName()
    {
        return __('Update user', 'mantiq');
    }

    public function getDescription()
    {
        return __('Update a generic user.', 'mantiq');
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
                    'description' => __('The ID of the newly created user.', 'mantiq'),
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
        return Plugin::getPath('editor/views/actions/users/update-user.php');
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

        $userArguments = [
            'ID' => $userId,
        ];

        $updateUsername = $invocation->getArgument('updateUsername', false);
        $updateEmail    = $invocation->getArgument('updateEmail', false);
        $updatePassword = $invocation->getArgument('updatePassword', false);
        $updateRole     = $invocation->getArgument('updateRole', false);

        if ($updateRole) {
            $userArguments['role'] = $invocation->getArgument('role');
        }

        if ($updateUsername) {
            $userArguments['user_login'] = $invocation->getEvaluatedArgument('username');
        }

        if ($updateEmail) {
            $userArguments['user_email'] = $invocation->getEvaluatedArgument('email');
        }

        if ($updatePassword) {
            $userArguments['user_pass'] = $invocation->getEvaluatedArgument('password');
        }

        $customArguments = json_decode($invocation->getEvaluatedArgument('customArguments', '{}'), true);

        $userArguments = array_merge($userArguments, $customArguments ?: []);

        $userId = wp_update_user($userArguments);

        if ($userId instanceof \WP_Error) {
            return [
                'success' => false,
                'error'   => new \Exception(
                    sprintf("The user could not be updated: %s", $userId->get_error_message())
                ),
                'user_id' => 0,
                'user'    => [],
            ];
        }

        if ($updateUsername) {
            $GLOBALS['wpdb']->update(
                $GLOBALS['wpdb']->users,
                ['user_login' => sanitize_user($userArguments['user_login'], true)],
                ['ID' => $userId]
            );
        }

        return [
            'success' => true,
            'user_id' => $userId,
            'user'    => get_user_by('id', $userId)->to_array(),
        ];
    }
}
