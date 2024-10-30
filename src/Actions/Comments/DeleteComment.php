<?php

namespace Mantiq\Actions\Comments;

use Mantiq\Models\Action;
use Mantiq\Models\ActionInvocationContext;
use Mantiq\Models\DataType;
use Mantiq\Models\OutputDefinition;
use Mantiq\Plugin;

class DeleteComment extends Action
{
    public function getName()
    {
        return __('Delete comment', 'mantiq');
    }

    public function getDescription()
    {
        return __('Delete a generic comment.', 'mantiq');
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
                    'name'        => __('Comment deletion', 'mantiq'),
                    'description' => __('Whether the comment has been deleted or not.', 'mantiq'),
                    'type'        => DataType::boolean(),
                ]
            ),
        ];
    }

    public function getTemplate()
    {
        return Plugin::getPath('editor/views/actions/comments/delete-comment.php');
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

        $commentId = wp_delete_comment($commentId, true);

        if (!$commentId) {
            return [
                'success' => false,
                'error'   => new \Exception("The comment could not be deleted."),
            ];
        }

        return [
            'success' => true,
        ];
    }
}
