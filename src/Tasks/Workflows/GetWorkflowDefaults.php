<?php

namespace Mantiq\Tasks\Workflows;

use Mantiq\Support\Strings;

class GetWorkflowDefaults
{
    public static function invoke()
    {
        return [
            'uid'      => Strings::uid(),
            'name'     => 'Untitled',
            'enabled'  => false,
            'tree'     => [
                'uid'        => Strings::uid(),
                'properties' => [
                    'type'      => 'schedule',
                    'arguments' => [
                        'schedule' => [
                            'frequency' => 'hourly',
                            'startDate' => '',
                        ],
                        'webhook'  => [
                            'slug'       => Strings::uid(),
                            'parameters' => [],
                        ],
                    ],
                ],
                'children'   => [],
                'type'       => 'trigger',
            ],
            'settings' => [],
            'type'     => 'schedule',
            'version'  => '1',
        ];
    }
}
