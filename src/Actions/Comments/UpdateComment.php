<?php

namespace Mantiq\Actions\Comments;

use Mantiq\Models\Action;
use Mantiq\Models\ActionInvocationContext;
use Mantiq\Models\DataType;
use Mantiq\Models\OutputDefinition;
use Mantiq\Plugin;
use Mantiq\Support\CommonDataTypes;

class UpdateComment extends Action
{
    public function getName()
    {
        return __('Update comment', 'mantiq');
    }

    public function getDescription()
    {
        return __('Update a generic comment.', 'mantiq');
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
        return Plugin::getPath('editor/views/actions/comments/update-comment.php');
    }

    public function invoke(ActionInvocationContext $invocation)
    {
        $rawCommentId = $invocation->getEvaluatedArgument('id');
        if (is_numeric($rawCommentId)) {
            $commentId = (int) $rawCommentId;
        } else {
            return [
                'success' => false,
                'error'   => new \Exception("The comment ID has not been provided."),
            ];
        }

        $userArguments = [
            'comment_ID' => $commentId,
        ];

        $updateAuthorName  = $invocation->getArgument('updateAuthorName', false);
        $updateAuthorEmail = $invocation->getArgument('updateAuthorEmail', false);
        $updateContent     = $invocation->getArgument('updateContent', false);
        $updateStatus      = $invocation->getArgument('updateStatus', false);

        if ($updateAuthorName) {
            $userArguments['comment_author'] = $invocation->getEvaluatedArgument('name');
        }

        if ($updateAuthorEmail) {
            $userArguments['comment_author_email'] = $invocation->getEvaluatedArgument('email');
        }

        if ($updateContent) {
            $userArguments['comment_content'] = $invocation->getEvaluatedArgument('content');
        }

        if ($updateStatus) {
            $userArguments['comment_approved'] = $invocation->getEvaluatedArgument('status');
        }

        $customArguments = json_decode($invocation->getEvaluatedArgument('customArguments', '{}'), true);

        $userArguments = array_merge($userArguments, $customArguments ?: []);

        $update = wp_update_comment($userArguments, true);

        if ($update instanceof \WP_Error) {
            return [
                'success'           => false,
                'error'             => new \Exception(
                    sprintf("The comment could not be updated: %s", $update->get_error_message())
                ),
                'comment_id'        => 0,
                'comment_permalink' => '',
                'comment'           => [],
            ];
        }

        return [
            'success'           => true,
            'comment_id'        => $commentId,
            'comment_permalink' => get_comment_link($commentId),
            'comment'           => get_comment($commentId)->to_array(),
        ];
    }
}
