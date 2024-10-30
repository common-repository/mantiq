<?php

namespace Mantiq\Actions\Metadata;

use Mantiq\Models\Action;
use Mantiq\Models\ActionInvocationContext;
use Mantiq\Models\DataType;
use Mantiq\Models\OutputDefinition;
use Mantiq\Plugin;

class UpdateMetadata extends Action
{
    public function getName()
    {
        return __('Update metadata', 'mantiq');
    }

    public function getDescription()
    {
        return __('Update a generic metadata.', 'mantiq');
    }

    public function getGroup()
    {
        return __('Metadata', 'mantiq');
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
        return Plugin::getPath('editor/views/actions/metadata/update-metadata.php');
    }

    public function invoke(ActionInvocationContext $invocation)
    {
        $metadataObjectId   = $invocation->getEvaluatedArgument('id');
        $metadataObjectType = $invocation->getArgument('type', 'post');

        if (empty($metadataObjectId) || empty($metadataObjectType)) {
            return [
                'success' => false,
                'error'   => new \Exception("The object ID or type is missing."),
            ];
        }

        $metadataEntries = $invocation->getArgument('entries', []);
        $updatedEntries    = [];

        foreach ($metadataEntries as $metadataEntry) {
            $metadataArguments = [
                'key'   => $metadataEntry['key'],
                'value' => $invocation->getEvaluatedValue($metadataEntry['value']),
            ];

            $metadataEntryId = update_metadata(
                $metadataObjectType,
                $metadataObjectId,
                $metadataArguments['key'],
                $metadataArguments['value']
            );

            if ($metadataEntryId !== false) {
                $metadataArguments['meta_id'] = $metadataEntryId;

                $updatedEntries[] = $metadataArguments;
            }
        }

        return [
            'success' => true,
            'entries' => $updatedEntries,
        ];
    }
}
