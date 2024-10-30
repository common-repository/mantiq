<?php

namespace Mantiq\Actions\Users;

use Mantiq\Models\Action;
use Mantiq\Models\ActionInvocationContext;
use Mantiq\Models\DataType;
use Mantiq\Models\OutputDefinition;
use Mantiq\Plugin;

class QueryUsers extends Action
{
    public function getName()
    {
        return __('Query users', 'mantiq');
    }

    public function getDescription()
    {
        return __('Query a list of users.', 'mantiq');
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
                    'id'          => 'count',
                    'name'        => __('Number of users', 'mantiq'),
                    'description' => __('The count of matching users.', 'mantiq'),
                    'type'        => DataType::integer(),
                ]
            ),
            new OutputDefinition(
                [
                    'id'          => 'users',
                    'name'        => __('Users', 'mantiq'),
                    'description' => __('An array of users (WP_User).', 'mantiq'),
                    'type'        => DataType::array(
                        [
                            [
                                'id'   => 'user_title',
                                'name' => 'User title',
                                'type' => DataType::string(),
                            ],
                            [
                                'id'   => 'user_date',
                                'name' => 'User date',
                                'type' => DataType::string(),
                            ],
                            [
                                'id'   => 'user_slug',
                                'name' => 'User slug',
                                'type' => DataType::string(),
                            ],
                        ]
                    ),
                ]
            ),
        ];
    }

    public function getTemplate()
    {
        return Plugin::getPath('editor/views/actions/users/query-users.php');
    }

    public function invoke(ActionInvocationContext $invocation)
    {
        $customArguments = json_decode($invocation->getEvaluatedArgument('customArguments', '{}'), true);

        $query = new \WP_User_Query($customArguments);
        $users = $query->get_results() ?: [];

        return [
            'success' => true,
            'count'   => count($users),
            'users'   => $users,
        ];
    }
}
