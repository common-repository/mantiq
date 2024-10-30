<?php

namespace Mantiq\Actions\Options;

use Mantiq\Models\Action;
use Mantiq\Models\ActionInvocationContext;
use Mantiq\Models\DataType;
use Mantiq\Models\OutputDefinition;
use Mantiq\Plugin;

class UpdateOption extends Action
{
    public function getName()
    {
        return __('Update option', 'mantiq');
    }

    public function getDescription()
    {
        return __('Update a generic option.', 'mantiq');
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
        return Plugin::getPath('editor/views/actions/options/update-option.php');
    }

    public function invoke(ActionInvocationContext $invocation)
    {
        $options        = $invocation->getArgument('options', []);
        $updatedOptions = [];

        foreach ($options as $option) {
            $updatedOptions[$option['key']] = $invocation->getEvaluatedValue($option['value']);
            update_option(
                $option['key'],
                $updatedOptions[$option['key']]
            );
        }

        return [
            'success' => true,
            'options' => $updatedOptions,
        ];
    }
}
