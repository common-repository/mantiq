<?php

return [
    'slug'    => 'mantiq',
    'version' => '1.4.0',
    'path'    => [
        'base'      => wp_normalize_path(realpath(plugin_dir_path(__FILE__))),
        'languages' => wp_normalize_path(realpath(plugin_dir_path(__FILE__))).'languages',
    ],
    'url'     => [
        'base'      => plugins_url('', __FILE__),
        'apiBase'   => '/mantiq',
        'namespace' => 'mantiq/v1',
    ],
    'db'      => [
        'prefix'  => $GLOBALS['wpdb']->prefix,
        'charset' => $GLOBALS['wpdb']->get_charset_collate(),
        'tables'  => [
            'workflows' => $GLOBALS['wpdb']->prefix.'mantiq_workflows',
            'log'       => $GLOBALS['wpdb']->prefix.'mantiq_log',
        ],
    ],
];
