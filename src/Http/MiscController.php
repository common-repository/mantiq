<?php

namespace Mantiq\Http;

use Mantiq\Concerns\Singleton;
use Mantiq\Http\Routes\GetConfigRoute;

class MiscController
{
    use Singleton;

    public function __construct()
    {
        add_action('rest_api_init', [$this, 'register']);
    }

    public function register()
    {
        GetConfigRoute::register();
    }
}
