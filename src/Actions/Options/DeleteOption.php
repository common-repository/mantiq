<?php

namespace Mantiq\Actions\Options;

use Mantiq\Models\Action;
use Mantiq\Models\ActionInvocationContext;
use Mantiq\Models\DataType;
use Mantiq\Models\OutputDefinition;
use Mantiq\Plugin;

class DeleteOption extends Action
{
    public function getName()
    {
        return __('Delete option', 'mantiq');
    }

    public function getDescription()
    {
        return __('Delete a generic option.', 'mantiq');
    }

    public function getGroup()
    {
        return __('Options', 'mantiq');
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
        return Plugin::getPath('editor/views/actions/options/delete-option.php');
    }

    public function invoke(ActionInvocationContext $invocation)
    {
        $options        = $invocation->getArgument('options', []);
        $deletedOptions = [];

        foreach ($options as $option) {
            $deletedOptions[$option['key']] = delete_option($option['key']);
        }

        return [
            'success' => true,
            'options' => $deletedOptions,
        ];
    }
}
