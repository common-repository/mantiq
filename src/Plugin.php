<?php

namespace Mantiq;

use Mantiq\Concerns\Singleton;
use Mantiq\Http\ConnectionsController;
use Mantiq\Http\MiscController;
use Mantiq\Http\WorkflowsController;
use Mantiq\Migrations\Cleanup;
use Mantiq\Migrations\Migrate;
use Mantiq\Services\StartupRegistry;
use Mantiq\Support\Collection;
use Mantiq\Tasks\Actions\RegisterDefaultActions;
use Mantiq\Tasks\Triggers\RegisterDefaultTriggerEvents;
use Mantiq\Tasks\Triggers\RegisterDefaultTriggerForms;
use Mantiq\Tasks\Triggers\RegisterDefaultTriggerSchedules;
use Mantiq\WordPress\AdminPage;

class Plugin
{
    use Singleton;

    /**
     * @var Collection
     */
    public $environment;

    /**
     * @var \Composer\Autoload\ClassLoader
     */
    public $loader;

    /**
     * @param $environment
     * @param $loader
     */
    public function __construct($environment, $loader)
    {
        // Plugin's environment
        $this->environment = Collection::create($environment);
        $this->loader      = $loader;

        // Bootstrap admin page
        AdminPage::instance();

        // Installation
        register_activation_hook($this->environment['path.plugin'], static function () {
            Migrate::instance();
        });

        // Deactivation
        register_deactivation_hook($this->environment['path.plugin'], static function () {
            Cleanup::instance();
        });

        // REST API
        WorkflowsController::instance();
        MiscController::instance();
        ConnectionsController::instance();

        // Registration of main APIs and services
        RegisterDefaultTriggerEvents::invoke();

        add_action('plugins_loaded', function () {
            RegisterDefaultTriggerSchedules::invoke();
            RegisterDefaultTriggerForms::invoke();
            RegisterDefaultActions::invoke();
        });

        // Handle workflows
        StartupRegistry::instance();

        // Init hook
        do_action('mantiq/init', $this);
    }


    /**
     * @param $key
     * @param  null  $default
     *
     * @return Collection|mixed
     */
    public static function env($key = null, $default = null)
    {
        return $key === null ? static::instance()->environment : static::instance()->environment->get($key, $default);
    }

    /**
     * @param  string  $path
     *
     * @return string
     */
    public static function getUrl(string $path = ''): string
    {
        return static::instance()->environment['url.base'].'/'.$path;
    }

    /**
     * @param  string  $path
     *
     * @return string
     */
    public static function getPath(string $path = ''): string
    {
        return wp_normalize_path(static::instance()->environment['path.base'].DIRECTORY_SEPARATOR.$path);
    }

    public static function getOption(string $name, $default = null)
    {
        return get_option(static::prefix($name), $default);
    }

    public static function setOption(string $name, $value): bool
    {
        return update_option(static::prefix($name), $value);
    }

    public static function prefix(string $name)
    {
        return static::instance()->environment['slug'].'_'.$name;
    }

    public static function isPluginActive($plugin)
    {
        return in_array($plugin, apply_filters('active_plugins', get_option('active_plugins')), true);
    }
}
