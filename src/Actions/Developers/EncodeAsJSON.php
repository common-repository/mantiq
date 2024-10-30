<?php

namespace Mantiq\Actions\Developers;

use Mantiq\Models\Action;
use Mantiq\Models\ActionInvocationContext;
use Mantiq\Models\DataType;
use Mantiq\Models\OutputDefinition;
use Mantiq\Plugin;

class EncodeAsJSON extends Action
{
    public function getName()
    {
        return __('Encode as JSON', 'mantiq');
    }

    public function getDescription()
    {
        return __('Encode an output as a JSON.', 'mantiq');
    }

    public function getGroup()
    {
        return __('Developers - Utilities', 'mantiq');
    }

    public function getOutputs()
    {
        return [
            new OutputDefinition(
                [
                    'id'          => 'json',
                    'name'        => __('JSON string', 'mantiq'),
                    'description' => __('The encoded JSON string.', 'mantiq'),
                    'type'        => DataType::string(),
                ]
            ),
        ];
    }

    public function getTemplate()
    {
        return Plugin::getPath('editor/views/actions/developers/encode-json.php');
    }

    function invoke(ActionInvocationContext $invocation)
    {
        return [
            'json' => json_encode(
                $invocation->getRawValueOfArgument('content'),
                $invocation->getArgument('pretty_print') ? JSON_PRETTY_PRINT : 0
            ),
        ];
    }
}
