<?php

namespace Mantiq\Actions\Metadata;

use Mantiq\Models\Action;
use Mantiq\Models\ActionInvocationContext;
use Mantiq\Models\DataType;
use Mantiq\Models\OutputDefinition;
use Mantiq\Plugin;

class GetMetadata extends Action
{
    public function getName()
    {
        return __('Get metadata', 'mantiq');
    }

    public function getDescription()
    {
        return __('Get a generic metadata.', 'mantiq');
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
            new OutputDefinition(
                [
                    'id'          => 'entries',
                    'name'        => __('Entries', 'mantiq'),
                    'description' => __('A map of requested entries.', 'mantiq'),
                    'type'        => DataType::map(),
                ]
            ),
        ];
    }

    public function getTemplate()
    {
        return Plugin::getPath('editor/views/actions/metadata/get-metadata.php');
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
        $values          = [];

        foreach ($metadataEntries as $metadataEntry) {
            $values[$metadataEntry['key']] = get_metadata(
                $metadataObjectType,
                $metadataObjectId,
                $metadataEntry['key'],
                true
            ) ?: $invocation->getEvaluatedValue($metadataEntry['fallback']);
        }

        return [
            'success' => true,
            'entries' => $values,
        ];
    }
}
