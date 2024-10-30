<?php

namespace Mantiq\Http\Routes;

use Mantiq\Support\RestRoute;
use Mantiq\Tasks\Workflows\Repository\UpdateWorkflow;

class UpdateWorkflowRoute extends RestRoute
{
    const METHODS  = \WP_REST_Server::EDITABLE;
    const ENDPOINT = 'workflows/(?P<uid>.+)';

    public static function invoke(\WP_REST_Request $request)
    {
        return UpdateWorkflow::invoke($request->get_param('uid'), $request->get_params());
    }

    public static function check()
    {
        return current_user_can('manage_options');
    }
}
