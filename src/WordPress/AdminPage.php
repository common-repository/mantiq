<?php

namespace Mantiq\WordPress;

use Mantiq\Concerns\Singleton;
use Mantiq\Plugin;
use Mantiq\Support\Utils;
use Mantiq\Tasks\Utils\GetAppConfig;

class AdminPage
{
    use Singleton;

    const SLUG       = 'mantiq';
    const ICON       = 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCA1MTIgNTEyIj48cGF0aCBkPSJNMjU2LDBDMTE0LjYxLDAsMCwxMTQuNiwwLDI1NlYyNTZDMCwzOTcuNCwxMTQuNjEsNTEyLDI1Niw1MTJTNTEyLDM5Ny40LDUxMiwyNTZWMjU2QzUxMiwxMTQuNiwzOTcuMzksMCwyNTYsMFptNjMuNzgsMjM1LjY0TDI0MS40OSwzNzIuNzdIMjI3LjgybDEzLjY3LTkyLjQ2aC00Ni42Yy02LjYzLDAtOC4yOS0yLjg4LTUtOC42OCwxLjI1LTIuMDYsMS40NS0yLjY4LjYyLTEuODZxMzEuNjktNTUuMjEsNzctMTM1LjI4aDEzLjY2TDI2Ny41OSwyMjdoNDYuNTlRMzIyLjg4LDIyNywzMTkuNzgsMjM1LjY0WiIgZmlsbD0iI2E3YWFhZCIgZmlsbC1ydWxlPSJldmVub2RkIi8+PC9zdmc+DQo=';
    const CAPABILITY = 'manage_options';
    const POSITION   = 30;

    public function __construct()
    {
        add_action('admin_menu', [$this, 'registerMenu']);
        add_action('admin_enqueue_scripts', [$this, 'registerAssets'], 99);
    }

    public function registerMenu()
    {
        add_menu_page(
            __('Mantiq', 'mantiq'),
            __('Workflows', 'mantiq'),
            static::CAPABILITY,
            static::SLUG,
            [$this, 'renderPage'],
            static::ICON,
            self::POSITION
        );
    }

    public function registerAssets()
    {
        if ($GLOBALS['pagenow'] !== 'admin.php' || !isset($_REQUEST['page']) || $_REQUEST['page'] !== static::SLUG) {
            return;
        }

        wp_enqueue_style('material-icons', 'https://fonts.googleapis.com/icon?family=Material+Icons', [], null);
        wp_enqueue_style('mantiq-app', Plugin::getUrl('editor/dist/css/app.css'), ['material-icons'], null);

        wp_enqueue_script(
            'mantiq-vendors',
            Plugin::getUrl('editor/dist/js/chunk-vendors.js'),
            [],
            Plugin::env('version'),
            true
        );
        wp_enqueue_script(
            'mantiq-app',
            Plugin::getUrl('editor/dist/js/app.js'),
            ['mantiq-vendors'],
            Plugin::env('version'),
            true
        );

        // Config
        wp_localize_script('mantiq-app', 'AppConfig', GetAppConfig::invoke());

        do_action('mantiq/editor/assets');
    }

    public function renderPage()
    {
        $templates = [];

        foreach (glob(Plugin::getPath('/editor/views/partials/*.php')) as $file) {
            $id             = str_replace('.php', '-template', basename($file));
            $templates[$id] = Utils::captureFileContent($file);
        }

        $templates = apply_filters('mantiq/templates', $templates);

        include Plugin::getPath('editor/views/index.php');
    }
}
