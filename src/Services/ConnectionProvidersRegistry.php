<?php

namespace Mantiq\Services;

use Mantiq\Concerns\Singleton;
use Mantiq\Models\ConnectionProvider;
use Mantiq\Support\Collection;

class ConnectionProvidersRegistry
{
    use Singleton;

    /**
     * @var Collection<ConnectionProvider>|ConnectionProvider []
     */
    protected $providers;

    public function __construct()
    {
        $this->providers = Collection::create();
    }

    /**
     * @param $actionId
     * @param  string  $fallback
     *
     * @return ConnectionProvider
     */
    public static function get($actionId, $fallback = null)
    {
        return static::instance()->getConnectionProvider($actionId) ?: new $fallback();
    }

    public function getConnectionProvider($id)
    {
        return $this->providers->get($id);
    }

    public function addNewProvider(ConnectionProvider $connectionProvider)
    {
        $this->providers->set($connectionProvider->getId(), $connectionProvider);
    }

    public function toArray()
    {
        return $this->providers->toArray();
    }
}
