<?php

namespace Mantiq\Actions\Users;

use Mantiq\Models\Action;
use Mantiq\Models\ActionInvocationContext;
use Mantiq\Models\DataType;
use Mantiq\Models\OutputDefinition;
use Mantiq\Plugin;
use Mantiq\Support\CommonDataTypes;

class CreateUser extends Action
{
    public function getName()
    {
        return __('Create user', 'mantiq');
    }

    public function getDescription()
    {
        return __('Create a generic user.', 'mantiq');
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
        return Plugin::getPath('editor/views/actions/users/create-user.php');
    }

    public function invoke(ActionInvocationContext $invocation)
    {
        $customArguments = json_decode($invocation->getEvaluatedArgument('customArguments', '{}'), true);

        $userArguments = array_merge(
            [
                'user_login' => $invocation->getEvaluatedArgument('username'),
                'user_email' => $invocation->getEvaluatedArgument('email'),
                'user_pass'  => $invocation->getEvaluatedArgument('password', wp_generate_password( 12, false )),
                'role'       => $invocation->getArgument('role'),
            ],
            $customArguments ?: []
        );

        $userId = wp_insert_user($userArguments);

        if ($userId instanceof \WP_Error) {
            return [
                'success' => false,
                'error'   => new \Exception(
                    sprintf("The user could not be created: %s", $userId->get_error_message())
                ),
                'user_id' => 0,
                'user'    => [],
            ];
        }

        return [
            'success' => true,
            'user_id' => $userId,
            'user'    => get_user_by('id', $userId)->to_array(),
        ];
    }
}
