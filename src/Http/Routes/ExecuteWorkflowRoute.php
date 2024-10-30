<?php

namespace Mantiq\Http\Routes;

use Mantiq\Support\RestRoute;
use Mantiq\Support\Strings;

class ExecuteWorkflowRoute extends RestRoute
{
    const METHODS = \WP_REST_Server::READABLE;
    const ENDPOINT = 'webhook/execute/(?P<uid>.+)';

    public static function invoke(\WP_REST_Request $request)
    {
        return [
            'dispatched' => true,
            'context'    => [
                'reference'  => Strings::uid(),
                'parameters' => $request->get_params(),
            ],
        ];
    }

    public static function check()
    {
        return current_user_can('manage_options');
    }
}
