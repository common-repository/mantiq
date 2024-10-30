<?php

namespace Mantiq\Http\Routes;

use Mantiq\Support\RestRoute;
use Mantiq\Tasks\Workflows\Repository\CreateWorkflow;

class CreateWorkflowRoute extends RestRoute
{
    const METHODS  = \WP_REST_Server::CREATABLE;
    const ENDPOINT = 'workflows';

    public static function invoke(\WP_REST_Request $request)
    {
        return CreateWorkflow::invoke($request->get_params());
    }

    public static function check()
    {
        return current_user_can('manage_options');
    }
}
