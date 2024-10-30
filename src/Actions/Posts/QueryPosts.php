<?php

namespace Mantiq\Actions\Posts;

use Mantiq\Models\Action;
use Mantiq\Models\ActionInvocationContext;
use Mantiq\Models\DataType;
use Mantiq\Models\OutputDefinition;
use Mantiq\Plugin;

class QueryPosts extends Action
{
    public function getName()
    {
        return __('Query posts', 'mantiq');
    }

    public function getDescription()
    {
        return __('Query a list of posts.', 'mantiq');
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
                    'id'          => 'count',
                    'name'        => __('Number of posts', 'mantiq'),
                    'description' => __('The count of matching posts.', 'mantiq'),
                    'type'        => DataType::integer(),
                ]
            ),
            new OutputDefinition(
                [
                    'id'          => 'posts',
                    'name'        => __('Posts', 'mantiq'),
                    'description' => __('An array of posts (WP_Post).', 'mantiq'),
                    'type'        => DataType::array(
                        [
                            [
                                'id'   => 'post_title',
                                'name' => 'Post title',
                                'type' => DataType::string(),
                            ],
                            [
                                'id'   => 'post_date',
                                'name' => 'Post date',
                                'type' => DataType::string(),
                            ],
                            [
                                'id'   => 'post_slug',
                                'name' => 'Post slug',
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
        return Plugin::getPath('editor/views/actions/posts/query-posts.php');
    }

    public function invoke(ActionInvocationContext $invocation)
    {
        $customArguments = json_decode($invocation->getEvaluatedArgument('customArguments', '{}'), true);

        $query = new \WP_Query($customArguments);
        $posts = $query->get_posts();

        return [
            'success' => true,
            'count'   => count($posts),
            'posts'   => $posts,
        ];
    }
}
