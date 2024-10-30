<?php

namespace Mantiq\Models;

use Mantiq\Services\ActionsRegistry;

abstract class Action implements \JsonSerializable
{
    public function getId()
    {
        return basename(str_replace('\\', '/', static::class));
    }

    public function getOutputs()
    {
        return [];
    }

    public function getInputs()
    {
        return [];
    }

    public function getTemplate()
    {
        return '';
    }

    public function getName()
    {
        return 'Unnamed action';
    }

    public function getDescription()
    {
        return '';
    }

    public function getGroup()
    {
        return 'other';
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
    
    public function toArray()
    {
        return [
            'id'          => $this->getId(),
            'name'        => $this->getName(),
            'description' => $this->getDescription(),
            'outputs'     => $this->getOutputs(),
            'inputs'      => $this->getInputs(),
            'group'       => $this->getGroup(),
            'template'    => $this->getTemplateContent(),
        ];
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return $this->toArray();
    }

    public static function register()
    {
        ActionsRegistry::instance()->addNewAction(new static());
    }

    abstract function invoke(ActionInvocationContext $invocation);

}
