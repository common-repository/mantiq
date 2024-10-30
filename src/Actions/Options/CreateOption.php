<?php

namespace Mantiq\Actions\Options;

use Mantiq\Models\Action;
use Mantiq\Models\ActionInvocationContext;
use Mantiq\Models\DataType;
use Mantiq\Models\OutputDefinition;
use Mantiq\Plugin;

class CreateOption extends Action
{
    public function getName()
    {
        return __('Create option', 'mantiq');
    }

    public function getDescription()
    {
        return __('Create a generic option.', 'mantiq');
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
        return Plugin::getPath('editor/views/actions/options/create-option.php');
    }

    public function invoke(ActionInvocationContext $invocation)
    {
        $options      = $invocation->getArgument('options', []);
        $savedOptions = [];

        foreach ($options as $option) {
            $savedOptions[$option['key']] = $invocation->getEvaluatedValue($option['value']);
            add_option(
                $option['key'],
                $savedOptions[$option['key']]
            );
        }

        return [
            'success' => true,
            'options' => $savedOptions,
        ];
    }
}
