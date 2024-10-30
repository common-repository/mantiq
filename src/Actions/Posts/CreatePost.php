<?php

namespace Mantiq\Actions\Posts;

use Mantiq\Models\Action;
use Mantiq\Models\ActionInvocationContext;
use Mantiq\Models\DataType;
use Mantiq\Models\OutputDefinition;
use Mantiq\Plugin;
use Mantiq\Support\CommonDataTypes;

class CreatePost extends Action
{
    public function getName()
    {
        return __('Create post', 'mantiq');
    }

    public function getDescription()
    {
        return __('Create a generic post.', 'mantiq');
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
                    'description' => __('The ID of the newly created post.', 'mantiq'),
                    'type'        => DataType::integer(),
                ]
            ),
            new OutputDefinition(
                [
                    'id'          => 'post_permalink',
                    'name'        => __('Post Permalink', 'mantiq'),
                    'description' => __('The permalink newly created post.', 'mantiq'),
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
        return Plugin::getPath('editor/views/actions/posts/create-post.php');
    }

    public function invoke(ActionInvocationContext $invocation)
    {
        $rawAuthor = $invocation->getEvaluatedArgument('author');
        $authorId  = null;

        if (is_numeric($rawAuthor)) {
            $authorId = (int) $rawAuthor;
        } elseif (is_email($rawAuthor)) {
            $authorId = get_user_by('email', $rawAuthor);
        } elseif (!empty($rawAuthor)) {
            $authorId = get_user_by('login', $rawAuthor);
        }

        $customArguments = json_decode($invocation->getEvaluatedArgument('customArguments', '{}'), true);

        $userArguments = array_merge(
            [
                'post_title'   => $invocation->getEvaluatedArgument('title'),
                'post_content' => $invocation->getEvaluatedArgument('content'),
                'post_status'  => $invocation->getEvaluatedArgument('status'),
                'post_type'    => $invocation->getEvaluatedArgument('type', 'post'),
                'post_author'  => $authorId,
            ],
            $customArguments ?: []
        );

        $postId = wp_insert_post($userArguments, true);

        if ($postId instanceof \WP_Error) {
            return [
                'success'        => false,
                'error'          => new \Exception(
                    sprintf("The post could not be created: %s", $postId->get_error_message())
                ),
                'post_id'        => 0,
                'post_permalink' => '',
                'post'           => [],
            ];
        }

        return [
            'success'        => true,
            'post_id'        => $postId,
            'post_permalink' => get_permalink($postId),
            'post'           => get_post($postId)->to_array(),
        ];
    }
}
