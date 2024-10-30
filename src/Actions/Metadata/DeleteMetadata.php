<?php

namespace Mantiq\Actions\Metadata;

use Mantiq\Models\Action;
use Mantiq\Models\ActionInvocationContext;
use Mantiq\Models\DataType;
use Mantiq\Models\OutputDefinition;
use Mantiq\Plugin;

class DeleteMetadata extends Action
{
    public function getName()
    {
        return __('Delete metadata', 'mantiq');
    }

    public function getDescription()
    {
        return __('Delete a generic metadata.', 'mantiq');
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
        return Plugin::getPath('editor/views/actions/metadata/delete-metadata.php');
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
        $deletedEntries    = [];

        foreach ($metadataEntries as $metadataEntry) {
            $metadataArguments = [
                'key'   => $metadataEntry['key'],
                'value' => null,
            ];

            $metadataArguments['deleted'] = delete_metadata(
                $metadataObjectType,
                $metadataObjectId,
                $metadataArguments['key'],
                $metadataArguments['value']
            );

            $deletedEntries[] = $metadataArguments;
        }

        return [
            'success' => true,
            'entries' => $deletedEntries,
        ];
    }
}
