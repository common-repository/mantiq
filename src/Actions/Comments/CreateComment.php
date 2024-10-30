<?php

namespace Mantiq\Actions\Comments;

use Mantiq\Models\Action;
use Mantiq\Models\ActionInvocationContext;
use Mantiq\Models\DataType;
use Mantiq\Models\OutputDefinition;
use Mantiq\Plugin;
use Mantiq\Support\CommonDataTypes;

class CreateComment extends Action
{
    public function getName()
    {
        return __('Create comment', 'mantiq');
    }

    public function getDescription()
    {
        return __('Create a generic comment.', 'mantiq');
    }

    public function getGroup()
    {
        return __('Comments', 'mantiq');
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
                    'id'          => 'comment_id',
                    'name'        => __('Comment ID', 'mantiq'),
                    'description' => __('The ID of the newly created comment.', 'mantiq'),
                    'type'        => DataType::integer(),
                ]
            ),
            new OutputDefinition(
                [
                    'id'          => 'comment_permalink',
                    'name'        => __('Comment Permalink', 'mantiq'),
                    'description' => __('The permalink newly created comment.', 'mantiq'),
                    'type'        => DataType::string(),
                ]
            ),
            new OutputDefinition(
                [
                    'id'          => 'comment',
                    'name'        => __('Comment Object', 'mantiq'),
                    'description' => __('The comment object (WP_Comment).', 'mantiq'),
                    'type'        => CommonDataTypes::WP_Comment(),
                ]
            ),
        ];
    }

    public function getTemplate()
    {
        return Plugin::getPath('editor/views/actions/comments/create-comment.php');
    }

    public function invoke(ActionInvocationContext $invocation)
    {
        $customArguments = json_decode($invocation->getEvaluatedArgument('customArguments', '{}'), true);

        $userArguments = array_merge(
            [
                'comment_post_ID'      => $invocation->getEvaluatedArgument('postId'),
                'comment_content'      => $invocation->getEvaluatedArgument('content'),
                'comment_type'         => $invocation->getArgument('type', 'comment'),
                'comment_author'       => $invocation->getEvaluatedArgument('name'),
                'comment_author_email' => $invocation->getEvaluatedArgument('email'),
            ],
            $customArguments ?: []
        );

        $commentId = wp_insert_comment($userArguments);

        if ($commentId === false) {
            return [
                'success'           => false,
                'error'             => new \Exception('The comment could not be created.'),
                'comment_id'        => 0,
                'comment_permalink' => '',
                'comment'           => [],
            ];
        }

        wp_set_comment_status($commentId, $invocation->getArgument('status'));

        return [
            'success'           => true,
            'comment_id'        => $commentId,
            'comment_permalink' => get_comment_link($commentId),
            'comment'           => get_comment($commentId)->to_array(),
        ];
    }
}
