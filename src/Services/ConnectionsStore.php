<?php

namespace Mantiq\Services;

use Mantiq\Concerns\Singleton;
use Mantiq\Models\Connection;
use Mantiq\Plugin;
use Mantiq\Support\Collection;

class ConnectionsStore
{
    use Singleton;

    const OPTION_NAME = 'connections';

    /**
     * @var Collection
     */
    protected $store;

    public function __construct()
    {
        $json             = Plugin::getOption(static::OPTION_NAME, '{}');
        $this->store      = Collection::fromJson($json)
                                      ->map(static function ($connections) {
                                          return array_map(
                                              static function ($connection) {
                                                  return new Connection($connection);
                                              },
                                              $connections
                                          );
                                      });
        $initialSignature = $this->store->getSignature();
        add_action('shutdown', function () use ($initialSignature) {
            if ($initialSignature !== $this->store->getSignature()) {
                Plugin::setOption(static::OPTION_NAME, $this->store->toJson());
            }
        });
    }

    public function save($provider, $attributes)
    {
        $attributes['uid'] = md5($attributes['id']);
        $connection        = new Connection($attributes);
        $this->store->set("{$provider}.{$attributes['uid']}", $attributes);

        return $connection;
    }

    public function toArray()
    {
        return $this->store->all();
    }

    /**
     * @param  string  $provider
     * @param $connectionUid
     *
     * @return Connection
     */
    public function get(string $provider, $connectionUid)
    {
        return $this->store->get("{$provider}.{$connectionUid}");
    }
}
