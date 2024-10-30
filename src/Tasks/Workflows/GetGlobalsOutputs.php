<?php

namespace Mantiq\Tasks\Workflows;

use Mantiq\Models\DataType;
use Mantiq\Models\OutputDefinition;
use Mantiq\Support\CommonDataTypes;

class GetGlobalsOutputs
{
    public static function invoke()
    {
        return [
            'currentUser' => new OutputDefinition(
                [
                    'id'          => 'currentUser',
                    'name'        => __('Current user', 'mantiq'),
                    'description' => __('Currently logged in user.', 'mantiq'),
                    'type'        => CommonDataTypes::WP_User(),
                ]
            ),
            'request'     => new OutputDefinition(
                [
                    'id'          => 'request',
                    'name'        => __('HTTP Request', 'mantiq'),
                    'description' => __('Current HTTP request.', 'mantiq'),
                    'type'        => DataType::object(
                        [
                            [
                                'id'   => 'path',
                                'name' => 'Request path',
                                'type' => DataType::string(),
                            ],
                            [
                                'id'   => 'ip',
                                'name' => 'Request IP',
                                'type' => DataType::string(),
                            ],
                            [
                                'id'   => 'useragent',
                                'name' => 'Request Useragent',
                                'type' => DataType::string(),
                            ],
                            [
                                'id'   => 'headers',
                                'name' => 'Request HTTP Headers',
                                'type' => DataType::map(),
                            ],
                            [
                                'id'   => 'query',
                                'name' => 'Request query parameters',
                                'type' => DataType::map(),
                            ],
                            [
                                'id'   => 'post',
                                'name' => 'Request post parameters',
                                'type' => DataType::map(),
                            ],
                        ]
                    ),
                ]
            ),
        ];
    }
}
