<?php

namespace Mantiq\Models;

use Mantiq\Services\FormProvidersRegistry;

abstract class FormProvider implements \JsonSerializable
{
    public function getId()
    {
        return basename(str_replace('\\', '/', static::class));
    }

    public function getName()
    {
        return 'Unnamed action';
    }

    public function toArray()
    {
        return [
            'id'   => $this->getId(),
            'name' => $this->getName(),
        ];
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return $this->toArray();
    }

    public static function register()
    {
        FormProvidersRegistry::instance()->addNewProvider(new static());
    }

    abstract function getTriggers();

    public function getStartupDefinitionArguments($definition, Workflow $workflow)
    {
        return [];
    }

    abstract public function handleStartupDefinition(StartupDefinition $startupDefinition);

}
