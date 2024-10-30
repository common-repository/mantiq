<?php

namespace Mantiq\Services;

use Mantiq\Concerns\Singleton;
use Mantiq\Models\StartupDefinition;
use Mantiq\Models\Workflow;
use Mantiq\Plugin;
use Mantiq\Support\Collection;
use Mantiq\Tasks\Startup\ExtractStartupDefinition;
use Mantiq\Tasks\Startup\HandleStartupDefinition;
use Mantiq\Tasks\Startup\PurgeStartupDefinition;

class StartupRegistry
{
    use Singleton;

    const OPTION_NAME = 'startup';

    /**
     * @var Collection
     */
    protected $store;

    public function __construct()
    {
        add_action('plugins_loaded', function () {
            $json             = Plugin::getOption(static::OPTION_NAME, '{}');
            $this->store      = Collection::fromJson($json)
                                          ->map(static function ($startupDefinition) {
                                              return new StartupDefinition($startupDefinition);
                                          });
            $initialSignature = $this->store->getSignature();

            $this->handle();

            add_action('shutdown', function () use ($initialSignature) {
                if ($initialSignature !== $this->store->getSignature()) {
                    Plugin::setOption(static::OPTION_NAME, $this->store->toJson());
                }
            });
        });
    }

    public function register(Workflow $workflow)
    {
        $this->deregister($workflow);

        if ($workflow->enabled) {
            $this->store->set($workflow->uid, ExtractStartupDefinition::invoke($workflow));
            WorkflowLogger::queueWrite(null, $workflow->uid, null, 'Workflow startup adjusted');
        }
    }

    public function deregister(Workflow $workflow)
    {
        $startupDefinition = $this->store->get($workflow->uid);

        if ($startupDefinition) {
            PurgeStartupDefinition::invoke($workflow, $startupDefinition);
            $this->store->remove($workflow->uid);
        }
    }

    public function handle()
    {
        foreach ($this->store as $startupDefinition) {
            HandleStartupDefinition::invoke($startupDefinition);
        }
    }

}
