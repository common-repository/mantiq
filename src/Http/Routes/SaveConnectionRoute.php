<?php

namespace Mantiq\Http\Routes;

use Mantiq\Support\RestRoute;
use Mantiq\Tasks\Connections\Repository\SaveConnection;

class SaveConnectionRoute extends RestRoute
{
    const METHODS  = \WP_REST_Server::EDITABLE;
    const ENDPOINT = 'connections';

    public static function invoke(\WP_REST_Request $request)
    {
        return SaveConnection::invoke($request->get_params());
    }

    public static function check()
    {
        return current_user_can('manage_options');
    }
}
