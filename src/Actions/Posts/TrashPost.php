<?php

namespace Mantiq\Actions\Posts;

use Mantiq\Models\Action;
use Mantiq\Models\ActionInvocationContext;
use Mantiq\Models\DataType;
use Mantiq\Models\OutputDefinition;
use Mantiq\Plugin;

class TrashPost extends Action
{
    public function getName()
    {
        return __('Trash post', 'mantiq');
    }

    public function getDescription()
    {
        return __('Trash a generic post.', 'mantiq');
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
        ];
    }

    public function getTemplate()
    {
        return Plugin::getPath('editor/views/actions/posts/trash-post.php');
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

        $postId = wp_trash_post($postId);

        if (!$postId) {
            return [
                'success' => false,
                'error'   => new \Exception("The post could not be deleted."),
            ];
        }

        return [
            'success' => true,
        ];
    }
}
