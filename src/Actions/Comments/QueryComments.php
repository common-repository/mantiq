<?php

namespace Mantiq\Actions\Comments;

use Mantiq\Models\Action;
use Mantiq\Models\ActionInvocationContext;
use Mantiq\Models\DataType;
use Mantiq\Models\OutputDefinition;
use Mantiq\Plugin;

class QueryComments extends Action
{
    public function getName()
    {
        return __('Query comments', 'mantiq');
    }

    public function getDescription()
    {
        return __('Query a list of comments.', 'mantiq');
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
                    'id'          => 'count',
                    'name'        => __('Number of comments', 'mantiq'),
                    'description' => __('The count of matching comments.', 'mantiq'),
                    'type'        => DataType::integer(),
                ]
            ),
            new OutputDefinition(
                [
                    'id'          => 'comments',
                    'name'        => __('Comments', 'mantiq'),
                    'description' => __('An array of comments (WP_Comment).', 'mantiq'),
                    'type'        => DataType::array(
                        [
                            [
                                'id'   => 'comment_title',
                                'name' => 'Comment title',
                                'type' => DataType::string(),
                            ],
                            [
                                'id'   => 'comment_date',
                                'name' => 'Comment date',
                                'type' => DataType::string(),
                            ],
                            [
                                'id'   => 'comment_slug',
                                'name' => 'Comment slug',
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
        return Plugin::getPath('editor/views/actions/comments/query-comments.php');
    }

    public function invoke(ActionInvocationContext $invocation)
    {
        $customArguments = json_decode($invocation->getEvaluatedArgument('customArguments', '{}'), true);

        $query    = new \WP_Comment_Query($customArguments);
        $comments = $query->get_comments();

        return [
            'success'  => true,
            'count'    => count($comments),
            'comments' => $comments,
        ];
    }
}
