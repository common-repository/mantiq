<?php

namespace Mantiq\Tasks\Utils;

use Mantiq\Plugin;
use Mantiq\Services\ActionsRegistry;
use Mantiq\Services\ConnectionsStore;
use Mantiq\Services\TriggersRegistry;
use Mantiq\Tasks\Workflows\GetGlobalsOutputs;
use Mantiq\Tasks\Workflows\GetWorkflowDefaults;

class GetAppConfig
{
    public static function invoke()
    {
        if (!function_exists('get_editable_roles')) {
            require_once(ABSPATH.'wp-admin/includes/user.php');
        }

        return [
            'url'         => [
                'site'           => Plugin::getUrl(),
                'api'            => [
                    'wp'    => rest_url(),
                    'base'  => rest_url(Plugin::env('url.namespace')),
                    'nonce' => wp_create_nonce('wp_rest'),
                ],
                'webhookBaseUrl' => rest_url(Plugin::env('url.namespace').'/webhook/execute/SLUG'),
            ],
            'triggers'    => TriggersRegistry::instance()->toArray(),
            'actions'     => ActionsRegistry::instance()->toArray(),
            'connections' => (object) ConnectionsStore::instance()->toArray(),
            'globals'     => GetGlobalsOutputs::invoke(),
            'workflow'    => [
                'defaults' => GetWorkflowDefaults::invoke(),
            ],
        ];
    }
}
