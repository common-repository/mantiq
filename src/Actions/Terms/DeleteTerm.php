<?php

namespace Mantiq\Actions\Terms;

use Mantiq\Models\Action;
use Mantiq\Models\ActionInvocationContext;
use Mantiq\Models\DataType;
use Mantiq\Models\OutputDefinition;
use Mantiq\Plugin;

class DeleteTerm extends Action
{
    public function getName()
    {
        return __('Delete term', 'mantiq');
    }

    public function getDescription()
    {
        return __('Delete a generic term.', 'mantiq');
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
        return Plugin::getPath('editor/views/actions/terms/delete-term.php');
    }

    public function invoke(ActionInvocationContext $invocation)
    {
        $rawTermId = $invocation->getEvaluatedArgument('id');
        $taxonomy  = $invocation->getArgument('taxonomy', false);

        if (is_numeric($rawTermId)) {
            $termId = (int) $rawTermId;
        } elseif (!empty($rawTermId)) {
            $termId = get_term_by('slug', $rawTermId, $taxonomy)->term_id ?? 0;
        } else {
            return [
                'success' => false,
                'error'   => new \Exception("The term ID has not been provided."),
            ];
        }

        $termId = wp_delete_term($termId, $taxonomy);

        if (!$termId) {
            return [
                'success' => false,
                'error'   => new \Exception("The term could not be deleted."),
            ];
        }

        return [
            'success' => true,
        ];
    }
}
