<?php

namespace Mantiq\Http\Routes;

use Mantiq\Support\RestRoute;
use Mantiq\Tasks\Log\Repository\GetLogEntries;

class GetWorkflowLogRoute extends RestRoute
{
    const METHODS  = \WP_REST_Server::READABLE;
    const ENDPOINT = 'workflows/(?P<uid>.+?)/log';

    public static function invoke(\WP_REST_Request $request)
    {
        $query = [
            'conditions' => [
                'workflow_uid' => $request->get_param('uid'),
            ],
        ];

        if ($request->get_param('node_uid')) {
            $query['conditions']['node_uid'] = $request->get_param('node_uid');
        }

        return GetLogEntries::invoke($query);
    }

    public static function check()
    {
        return current_user_can('manage_options');
    }
}
