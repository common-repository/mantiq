<?php

namespace Mantiq\Services;

use Mantiq\Concerns\Singleton;
use Mantiq\Models\FormProvider;
use Mantiq\Support\Collection;

class FormProvidersRegistry
{
    use Singleton;

    /**
     * @var Collection<FormProvider>|FormProvider []
     */
    protected $providers;

    public function __construct()
    {
        $this->providers = Collection::create();
    }

    /**
     * @param  string  $providerId
     * @param  string  $fallback
     *
     * @return FormProvider
     */
    public static function get($providerId, $fallback = null)
    {
        return static::instance()->getFormProvider($providerId) ?: new $fallback();
    }

    public function getFormProvider($id)
    {
        return $this->providers->get($id);
    }

    public function getFormTriggers()
    {
        $triggers = Collection::create();

        foreach ($this->providers as $provider) {
            foreach ($provider->getTriggers() as $trigger) {
                $triggers[$trigger->getUid()] = $trigger;
            }
        }

        return $triggers;
    }

    public function addNewProvider(FormProvider $formProvider)
    {
        $this->providers->set($formProvider->getId(), $formProvider);
    }

    public function toArray()
    {
        return $this->providers->toArray();
    }
}
