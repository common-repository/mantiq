<?php

namespace Mantiq\Actions;

use Mantiq\Models\Action;
use Mantiq\Models\ActionInvocationContext;

class VoidAction extends Action
{
    public function getName()
    {
        return __('Void', 'mantiq');
    }

    public function getDescription()
    {
        return __('Void action.', 'mantiq');
    }

    public function getGroup()
    {
        return __('Other', 'mantiq');
    }

    public function getOutputs()
    {
        return [];
    }

    public function getTemplate()
    {
        return '';
    }

    public function invoke(ActionInvocationContext $invocation)
    {
        // TODO: Implement invoke() method.
    }
}
