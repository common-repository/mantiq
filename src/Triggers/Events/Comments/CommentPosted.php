<?php

namespace Mantiq\Triggers\Events\Comments;

use Mantiq\Models\DataType;
use Mantiq\Models\OutputDefinition;
use Mantiq\Models\TriggerEvent;
use Mantiq\Support\CommonDataTypes;

class CommentPosted extends TriggerEvent
{
    public function getId()
    {
        return 'comment_post';
    }

    public function getName()
    {
        return __('Comment posted', 'mantiq');
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
                    'id'   => 'comment_id',
                    'name' => __('Comment ID', 'mantiq'),
                    'type' => DataType::integer(),
                ]
            ),
            new OutputDefinition(
                [
                    'id'   => 'comment_approved',
                    'name' => __('1 if the comment is approved, 0 if not', 'mantiq'),
                    'type' => DataType::integer(),
                ]
            ),
            new OutputDefinition(
                [
                    'id'   => 'comment',
                    'name' => __('Comment object', 'mantiq'),
                    'type' => CommonDataTypes::WP_Comment(),
                ]
            ),
        ];
    }

    public function getNamedArgumentsFromRawEvent($eventArgs)
    {
        return [
            'comment_id'       => $eventArgs[0],
            'comment_approved' => $eventArgs[1],
            'comment'          => $eventArgs[2],
        ];
    }
}
