<?php

namespace Mantiq\Support;

use Mantiq\Plugin;

abstract class RestRoute
{
    const METHODS  = \WP_REST_Server::READABLE;
    const ENDPOINT = '';

    public static function register()
    {
        register_rest_route(
            Plugin::env('url.namespace'),
            static::ENDPOINT,
            [
                'methods'             => static::METHODS,
                'callback'            => static function (\WP_REST_Request $request) {
                    try {
                        return static::invoke($request);
                    } catch (\Exception $exception) {
                        wp_send_json(
                            [
                                'success' => false,
                                'error'   => $exception->getMessage(),
                                'trace'   => $exception->getTrace(),
                            ],
                            500
                        );
                    }
                },
                'permission_callback' => [static::class, 'check'],
                'args'                => [],
            ]
        );
    }

    public static function invoke(\WP_REST_Request $request)
    {
        return $request;
    }

    public static function check()
    {
        return true;
    }
}
