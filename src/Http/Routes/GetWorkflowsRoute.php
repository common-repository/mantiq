<?php

namespace Mantiq\Http\Routes;

use Mantiq\Support\RestRoute;
use Mantiq\Tasks\Workflows\Repository\GetWorkflows;

class GetWorkflowsRoute extends RestRoute
{
    const ENDPOINT = 'workflows';

    public static function invoke(\WP_REST_Request $request)
    {
        return GetWorkflows::invoke()->toArray();
    }

    public static function check()
    {
        return current_user_can('manage_options');
    }
}
