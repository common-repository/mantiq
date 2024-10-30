<?php

namespace Mantiq\Actions\Terms;

use Mantiq\Models\Action;
use Mantiq\Models\ActionInvocationContext;
use Mantiq\Models\DataType;
use Mantiq\Models\OutputDefinition;
use Mantiq\Plugin;
use Mantiq\Support\CommonDataTypes;

class CreateTerm extends Action
{
    public function getName()
    {
        return __('Create term', 'mantiq');
    }

    public function getDescription()
    {
        return __('Create a generic term.', 'mantiq');
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
            new OutputDefinition(
                [
                    'id'          => 'term_id',
                    'name'        => __('Term ID', 'mantiq'),
                    'description' => __('The ID of the newly created term.', 'mantiq'),
                    'type'        => DataType::integer(),
                ]
            ),
            new OutputDefinition(
                [
                    'id'          => 'term_taxonomy_id',
                    'name'        => __('Term Taxonomy ID', 'mantiq'),
                    'description' => __('The ID of the newly created term.', 'mantiq'),
                    'type'        => DataType::integer(),
                ]
            ),
            new OutputDefinition(
                [
                    'id'          => 'term_permalink',
                    'name'        => __('Term Permalink', 'mantiq'),
                    'description' => __('The permalink newly created term.', 'mantiq'),
                    'type'        => DataType::string(),
                ]
            ),
            new OutputDefinition(
                [
                    'id'          => 'term',
                    'name'        => __('Term Object', 'mantiq'),
                    'description' => __('The term object (WP_Term).', 'mantiq'),
                    'type'        => CommonDataTypes::WP_Term(),
                ]
            ),
        ];
    }

    public function getTemplate()
    {
        return Plugin::getPath('editor/views/actions/terms/create-term.php');
    }

    public function invoke(ActionInvocationContext $invocation)
    {
        $taxonomy  = $invocation->getEvaluatedArgument('taxonomy');
        $rawParent = $invocation->getEvaluatedArgument('parent');
        $parentId  = null;

        if (is_numeric($rawParent)) {
            $parentId = (int) $rawParent;
        } elseif (is_string($rawParent)) {
            $parentId = get_term_by('slug', $rawParent, $taxonomy)->term_id ?? null;
        }

        $customArguments = json_decode($invocation->getEvaluatedArgument('customArguments', '{}'), true);

        $userArguments = array_merge(
            [
                'description' => $invocation->getEvaluatedArgument('description'),
                'parent'      => $parentId,
            ],
            $customArguments ?: []
        );

        $term = wp_insert_term(
            $invocation->getEvaluatedArgument('name'),
            $taxonomy,
            $userArguments
        );

        if ($term instanceof \WP_Error) {
            return [
                'success'          => false,
                'error'            => new \Exception(
                    sprintf("The term could not be created: %s", $term->get_error_message())
                ),
                'term_id'          => 0,
                'term_taxonomy_id' => 0,
                'term_permalink'   => '',
                'term'             => [],
            ];
        }

        return [
            'success'          => true,
            'term_id'          => $term['term_id'],
            'term_taxonomy_id' => $term['term_taxonomy_id'],
            'term_permalink'   => get_term_link($term['term_id']),
            'term'             => get_term($term['term_id'])->to_array(),
        ];
    }
}
