<?php

namespace Mantiq\Actions\Users;

use Mantiq\Models\Action;
use Mantiq\Models\ActionInvocationContext;
use Mantiq\Models\DataType;
use Mantiq\Models\OutputDefinition;
use Mantiq\Plugin;

class DeleteUser extends Action
{
    public function getName()
    {
        return __('Delete user', 'mantiq');
    }

    public function getDescription()
    {
        return __('Delete a generic user.', 'mantiq');
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
        ];
    }

    public function getTemplate()
    {
        return Plugin::getPath('editor/views/actions/users/delete-user.php');
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

        require_once(ABSPATH.'wp-admin/includes/user.php');
        $userId = wp_delete_user($userId);

        if (!$userId) {
            return [
                'success' => false,
                'error'   => new \Exception("The user could not be deleted."),
            ];
        }

        return [
            'success' => true,
        ];
    }
}
