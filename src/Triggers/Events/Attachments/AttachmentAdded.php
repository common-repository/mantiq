<?php

namespace Mantiq\Triggers\Events\Attachments;

use Mantiq\Models\DataType;
use Mantiq\Models\OutputDefinition;
use Mantiq\Models\TriggerEvent;
use Mantiq\Support\CommonDataTypes;

class AttachmentAdded extends TriggerEvent
{
    public function getId()
    {
        return 'add_attachment';
    }

    public function getName()
    {
        return __('Attachment added', 'mantiq');
    }

    public function getGroup()
    {
        return __('Attachments', 'mantiq');
    }

    public function getOutputs()
    {
        return [
            new OutputDefinition(
                [
                    'id'   => 'attachment_id',
                    'name' => __('Attachment ID', 'mantiq'),
                    'type' => DataType::integer(),
                ]
            ),
            new OutputDefinition(
                [
                    'id'   => 'attachment_permalink',
                    'name' => __('Attachment permalink', 'mantiq'),
                    'type' => DataType::string(),
                ]
            ),
            new OutputDefinition(
                [
                    'id'   => 'attachment',
                    'name' => __('Attachment object', 'mantiq'),
                    'type' => CommonDataTypes::WP_Post(),
                ]
            ),
        ];
    }

    public function getNamedArgumentsFromRawEvent($eventArgs)
    {
        return [
            'attachment_id'        => $eventArgs[0],
            'attachment_permalink' => get_permalink($eventArgs[0]),
            'attachment'           => $eventArgs[1],
        ];
    }

}
