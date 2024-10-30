<?php

namespace Mantiq\Actions\Posts;

use Mantiq\Models\Action;
use Mantiq\Models\ActionInvocationContext;
use Mantiq\Models\DataType;
use Mantiq\Models\OutputDefinition;
use Mantiq\Plugin;
use Mantiq\Support\CommonDataTypes;

class GetPost extends Action
{
    public function getName()
    {
        return __('Get post', 'mantiq');
    }

    public function getDescription()
    {
        return __('Get a generic post.', 'mantiq');
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
                    'id'          => 'success',
                    'name'        => __('Operation state', 'mantiq'),
                    'description' => __('Whether the operation succeeded or not.', 'mantiq'),
                    'type'        => DataType::boolean(),
                ]
            ),
            new OutputDefinition(
                [
                    'id'          => 'post_id',
                    'name'        => __('Post ID', 'mantiq'),
                    'description' => __('The ID of the of the retrieved post.', 'mantiq'),
                    'type'        => DataType::integer(),
                ]
            ),
            new OutputDefinition(
                [
                    'id'          => 'post_permalink',
                    'name'        => __('Post Permalink', 'mantiq'),
                    'description' => __('The permalink of the retrieved post.', 'mantiq'),
                    'type'        => DataType::string(),
                ]
            ),
            new OutputDefinition(
                [
                    'id'          => 'post',
                    'name'        => __('Post Object', 'mantiq'),
                    'description' => __('The post object (WP_Post).', 'mantiq'),
                    'type'        => CommonDataTypes::WP_Post(),
                ]
            ),
        ];
    }

    public function getTemplate()
    {
        return Plugin::getPath('editor/views/actions/posts/get-post.php');
    }

    public function invoke(ActionInvocationContext $invocation)
    {
        $rawPostId = trim($invocation->getEvaluatedArgument('id'));

        if (is_numeric($rawPostId)) {
            $postId = (int) $rawPostId;
        } elseif (!empty($rawPostId)) {
            $postId = get_page_by_path($rawPostId, get_post_types())->ID ?? 0;
        } else {
            return [
                'success' => false,
                'error'   => new \Exception("The post ID has not been provided."),
            ];
        }

        $customArguments = json_decode($invocation->getEvaluatedArgument('customArguments', '{}'), true);
        $userArguments   = array_merge(['ID' => $postId, 'posts_per_page' => 1], $customArguments ?: []);

        $post = get_post($userArguments['ID']);

        if (!$post instanceof \WP_Post) {
            return [
                'success'        => false,
                'error'          => new \Exception("The post could not be retrieved"),
                'post_id'        => 0,
                'post_permalink' => '',
                'post'           => [],
            ];
        }

        return [
            'success'        => true,
            'post_id'        => $post->ID,
            'post_permalink' => get_permalink($post),
            'post'           => $post->to_array(),
        ];
    }
}
