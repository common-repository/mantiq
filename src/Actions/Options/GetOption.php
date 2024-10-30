<?php

namespace Mantiq\Actions\Options;

use Mantiq\Models\Action;
use Mantiq\Models\ActionInvocationContext;
use Mantiq\Models\DataType;
use Mantiq\Models\OutputDefinition;
use Mantiq\Plugin;

class GetOption extends Action
{
    public function getName()
    {
        return __('Get option', 'mantiq');
    }

    public function getDescription()
    {
        return __('Get a generic option.', 'mantiq');
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
            new OutputDefinition(
                [
                    'id'          => 'options',
                    'name'        => __('Options', 'mantiq'),
                    'description' => __('A map of requested options.', 'mantiq'),
                    'type'        => DataType::map([], [
                        'id'     => 'keysOf',
                        'source' => 'options',
                        'field'  => 'key',
                    ]),
                ]
            ),
        ];
    }

    public function getTemplate()
    {
        return Plugin::getPath('editor/views/actions/options/get-option.php');
    }

    public function invoke(ActionInvocationContext $invocation)
    {
        $options       = $invocation->getArgument('options', []);
        $optionsValues = [];

        foreach ($options as $option) {
            $optionsValues[$option['key']] = get_option(
                $option['key'],
                $invocation->getEvaluatedValue($option['fallback']) ?: null
            );
        }

        return [
            'success' => true,
            'options' => $optionsValues,
        ];
    }
}
