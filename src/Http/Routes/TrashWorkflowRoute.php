<?php

namespace Mantiq\Http\Routes;

use Mantiq\Support\RestRoute;
use Mantiq\Tasks\Workflows\Repository\TrashWorkflow;

class TrashWorkflowRoute extends RestRoute
{
    const METHODS  = \WP_REST_Server::DELETABLE;
    const ENDPOINT = 'workflows/(?P<uid>.+)';

    public static function invoke(\WP_REST_Request $request)
    {
        return [
            'success' => TrashWorkflow::invoke($request->get_param('uid')),
        ];
    }

    public static function check()
    {
        return current_user_can('manage_options');
    }
}
