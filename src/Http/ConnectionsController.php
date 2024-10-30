<?php

namespace Mantiq\Http;

use Mantiq\Concerns\Singleton;
use Mantiq\Http\Routes\SaveConnectionRoute;

class ConnectionsController
{
    use Singleton;

    public function __construct()
    {
        add_action('rest_api_init', [$this, 'register']);
    }

    public function register()
    {
        SaveConnectionRoute::register();
    }
}
