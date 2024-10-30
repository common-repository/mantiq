<?php

namespace Mantiq\Tasks\Workflows;

use Mantiq\Support\Utils;

class GetGlobals
{
    public static function invoke()
    {
        return apply_filters('mantiq/globals', [
            'currentUser' => wp_get_current_user()->to_array(),
            'request'     => [
                'headers'   => Utils::getRequestHeaders(),
                'path'      => esc_html($_SERVER['REQUEST_URI']),
                'ip'        => esc_html($_SERVER['REMOTE_ADDR']),
                'useragent' => esc_html($_SERVER['HTTP_USER_AGENT']),
                'query'     => $_GET,
                'post'      => $_POST,
            ],
        ]);
    }
}
