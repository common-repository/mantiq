<?php

namespace Mantiq\Models;

use Mantiq\Support\Arrays;

class TriggerForm extends Model
{
    /**
     * @var FormProvider
     */
    protected $provider;

    public function __construct(FormProvider $provider, $rawAttributes)
    {
        $this->provider = $provider;
        parent::__construct($rawAttributes);
    }

    public function getUid()
    {
        return "{$this->provider->getId()}::{$this->getId()}";
    }

    public function getId()
    {
        return $this->attributes['id'] ?? 'anonymous';
    }

    public function getName()
    {
        return $this->attributes['name'] ?? __('Anonymous form', 'mantiq');
    }

    public function getProviderId()
    {
        return $this->attributes['providerId'] ?? 'anonymous';
    }

    public function getProvider()
    {
        return $this->attributes['provider'] ?? __('Anonymous', 'mantiq');
    }

    public function getOutputs()
    {
        return $this->attributes['outputs'] ?? [];
    }

    public function getTemplate()
    {
        return '';
    }

    protected function getTemplateContent()
    {
        if (!file_exists($this->getTemplate())) {
            return '';
        }

        ob_start();

        try {
            include $this->getTemplate();
        } catch (\Exception $exception) {
            printf('<div class="alert">%s</div>', $exception->getMessage());
        }

        return ob_get_clean();
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return [
            'id'         => $this->getId(),
            'uid'        => $this->getUid(),
            'name'       => $this->getName(),
            'providerId' => $this->provider->getId(),
            'provider'   => $this->provider->getName(),
            'outputs'    => $this->getOutputs(),
            'template'   => $this->getTemplateContent(),
        ];
    }

    public function getNamedArgumentsFromRawForm($args)
    {
        $outputsIds = Arrays::extract($this->getOutputs(), 'id');

        if (empty($outputsIds)) {
            return $args;
        }

        $namedArgs = [];
        foreach ($outputsIds as $outputIndex => $outputId) {
            $namedArgs[$outputId] = $args[$outputIndex] ?? null;
        }

        return $namedArgs;
    }

    public function getStartupDefinitionArguments($definition, Workflow $workflow)
    {
        return [];
    }

    public function handleStartupDefinition(StartupDefinition $startupDefinition)
    {
        // Nothing to do here
    }

    public function purgeStartupDefinition(StartupDefinition $startupDefinition)
    {
        // Nothing to do here
    }
}
