<?php

namespace Mantiq\Actions\Terms;

use Mantiq\Models\Action;
use Mantiq\Models\ActionInvocationContext;
use Mantiq\Models\DataType;
use Mantiq\Models\OutputDefinition;
use Mantiq\Plugin;
use Mantiq\Support\Arrays;

class AssignTermsToPost extends Action
{
    public function getName()
    {
        return __('Assign terms to post', 'mantiq');
    }

    public function getDescription()
    {
        return __('Assign terms to a post.', 'mantiq');
    }

    public function getGroup()
    {
        return __('Terms', 'mantiq');
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
        return Plugin::getPath('editor/views/actions/terms/assign-terms-to-post.php');
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

        $taxonomy = $invocation->getArgument('taxonomy', '');
        $terms    = Arrays::extract($invocation->getArgument('terms', []), 'id');
        $replace  = $invocation->getArgument('replace', false);

        $terms = wp_set_post_terms($postId, $terms, $taxonomy, !$replace);

        if (!is_array($terms)) {
            return [
                'success' => false,
                'error'   => new \Exception("The terms could not be assigned"),
                'terms'   => [],
            ];
        }

        return [
            'success' => true,
            'terms'   => $terms,
        ];
    }
}
