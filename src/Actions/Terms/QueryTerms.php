<?php

namespace Mantiq\Actions\Terms;

use Mantiq\Models\Action;
use Mantiq\Models\ActionInvocationContext;
use Mantiq\Models\DataType;
use Mantiq\Models\OutputDefinition;
use Mantiq\Plugin;

class QueryTerms extends Action
{
    public function getName()
    {
        return __('Query terms', 'mantiq');
    }

    public function getDescription()
    {
        return __('Query a list of terms.', 'mantiq');
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
                    'id'          => 'count',
                    'name'        => __('Number of terms', 'mantiq'),
                    'description' => __('The count of matching terms.', 'mantiq'),
                    'type'        => DataType::integer(),
                ]
            ),
            new OutputDefinition(
                [
                    'id'          => 'terms',
                    'name'        => __('Terms', 'mantiq'),
                    'description' => __('An array of terms (WP_Term).', 'mantiq'),
                    'type'        => DataType::array(
                        [
                            [
                                'id'   => 'term_title',
                                'name' => 'Term title',
                                'type' => DataType::string(),
                            ],
                            [
                                'id'   => 'term_date',
                                'name' => 'Term date',
                                'type' => DataType::string(),
                            ],
                            [
                                'id'   => 'term_slug',
                                'name' => 'Term slug',
                                'type' => DataType::string(),
                            ],
                        ]
                    ),
                ]
            ),
        ];
    }

    public function getTemplate()
    {
        return Plugin::getPath('editor/views/actions/terms/query-terms.php');
    }

    public function invoke(ActionInvocationContext $invocation)
    {
        $customArguments = json_decode($invocation->getEvaluatedArgument('customArguments', '{}'), true);

        $query = new \WP_Term_Query($customArguments);
        $terms = $query->get_terms();

        return [
            'success' => true,
            'count'   => count($terms),
            'terms'   => $terms,
        ];
    }
}
