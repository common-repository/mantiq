<?php

namespace Mantiq\Actions\Comments;

use Mantiq\Models\Action;
use Mantiq\Models\ActionInvocationContext;
use Mantiq\Models\DataType;
use Mantiq\Models\OutputDefinition;
use Mantiq\Plugin;
use Mantiq\Support\CommonDataTypes;

class GetComment extends Action
{
    public function getName()
    {
        return __('Get comment', 'mantiq');
    }

    public function getDescription()
    {
        return __('Get a generic comment.', 'mantiq');
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
                    'description' => __('The ID of the of the retrieved comment.', 'mantiq'),
                    'type'        => DataType::integer(),
                ]
            ),
            new OutputDefinition(
                [
                    'id'          => 'comment_permalink',
                    'name'        => __('Comment Permalink', 'mantiq'),
                    'description' => __('The permalink of the retrieved comment.', 'mantiq'),
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
        return Plugin::getPath('editor/views/actions/comments/get-comment.php');
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

        $customArguments = json_decode($invocation->getEvaluatedArgument('customArguments', '{}'), true);
        $userArguments   = array_merge(['ID' => $commentId, 'comments_per_page' => 1], $customArguments ?: []);

        $comment = get_comment($userArguments['ID']);

        if (!$comment instanceof \WP_Comment) {
            return [
                'success'        => false,
                'error'          => new \Exception("The comment could not be retrieved"),
                'comment_id'        => 0,
                'comment_permalink' => '',
                'comment'           => [],
            ];
        }

        return [
            'success'        => true,
            'comment_id'        => $comment->comment_ID,
            'comment_permalink' => get_comment_link($comment),
            'comment'           => $comment->to_array(),
        ];
    }
}
