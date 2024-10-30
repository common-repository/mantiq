<?php

namespace Mantiq\Actions\Developers;

use Mantiq\Models\Action;
use Mantiq\Models\ActionInvocationContext;
use Mantiq\Plugin;
use Mantiq\Support\Strings;

class EchoOutput extends Action
{
    public function getName()
    {
        return __('Echo', 'mantiq');
    }

    public function getDescription()
    {
        return __('Echo the content to the buffer.', 'mantiq');
    }

    public function getGroup()
    {
        return __('Developers - Utilities', 'mantiq');
    }

    public function getOutputs()
    {
        return [];
    }

    public function getTemplate()
    {
        return Plugin::getPath('editor/views/actions/developers/echo.php');
    }

    function invoke(ActionInvocationContext $invocation)
    {
        if (defined('REST_REQUEST')) {
            $output = $invocation->getEvaluatedArgumentWithoutEscaping('content');
            if (Strings::isJson($output)) {
                $output = json_decode($output, true);
            }

            wp_send_json($output);
        } else {
            echo $invocation->getEvaluatedArgumentWithoutEscaping('content');
        }

        return [];
    }
}
