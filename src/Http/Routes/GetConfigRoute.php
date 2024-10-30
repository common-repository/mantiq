<?php

namespace Mantiq\Http\Routes;

use Mantiq\Support\RestRoute;
use Mantiq\Tasks\Utils\GetAppConfig;

class GetConfigRoute extends RestRoute
{
    const METHODS  = \WP_REST_Server::READABLE;
    const ENDPOINT = 'config';

    public static function invoke(\WP_REST_Request $request)
    {
        return GetAppConfig::invoke();
    }

    public static function check()
    {
        return current_user_can('manage_options');
    }
}
