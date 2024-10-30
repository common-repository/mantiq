<?php

namespace Mantiq\Actions\Comments;

use Mantiq\Models\Action;
use Mantiq\Models\ActionInvocationContext;
use Mantiq\Models\DataType;
use Mantiq\Models\OutputDefinition;
use Mantiq\Plugin;

class TrashComment extends Action
{
    public function getName()
    {
        return __('Trash comment', 'mantiq');
    }

    public function getDescription()
    {
        return __('Trash a generic comment.', 'mantiq');
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
        ];
    }

    public function getTemplate()
    {
        return Plugin::getPath('editor/views/actions/comments/trash-comment.php');
    }

    public function invoke(ActionInvocationContext $invocation)
    {
        $rawPostId = $invocation->getEvaluatedArgument('id');

        if (is_numeric($rawPostId)) {
            $commentId = (int) $rawPostId;
        } else {
            return [
                'success' => false,
                'error'   => new \Exception("The comment ID has not been provided."),
            ];
        }

        $commentId = wp_trash_comment($commentId);

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
