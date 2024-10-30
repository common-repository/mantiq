<?php

namespace Mantiq\Tasks\Startup;

use Mantiq\Models\ExecutionArguments;
use Mantiq\Models\StartupDefinition;
use Mantiq\Plugin;
use Mantiq\Tasks\Workflows\Repository\GetWorkflow;
use Mantiq\Tasks\Workflows\RunWorkflow;

class HandleStartupDefinition
{
    public static function invoke(StartupDefinition $startupDefinition)
    {
        if ($startupDefinition->isSchedule()) {
            static::scheduleTrigger($startupDefinition);
        }

        if ($startupDefinition->isWebhook()) {
            static::routeTrigger($startupDefinition);
        }

        if ($startupDefinition->isEvent()) {
            static::listenToEvent($startupDefinition);
        }

        if ($startupDefinition->isForm()) {
            static::handleForm($startupDefinition);
        }
    }

    protected static function scheduleTrigger(StartupDefinition $startupDefinition)
    {
        $startupDefinition->getSchedule()->handleStartupDefinition($startupDefinition);
    }

    protected static function routeTrigger(StartupDefinition $startupDefinition)
    {
        add_action(
            'rest_api_init',
            function () use ($startupDefinition) {
                register_rest_route(
                    Plugin::env('url.namespace'),
                    $startupDefinition['arguments.route'],
                    [
                        'methods'             => \WP_REST_Server::ALLMETHODS,
                        'callback'            => function (\WP_REST_Request $request) use ($startupDefinition) {
                            try {
                                $workflow           = GetWorkflow::invoke($startupDefinition['workflowUid']);
                                $executionArguments = ExecutionArguments::fromRoute($startupDefinition, $request);

                                if (!$workflow) {
                                    throw new \Exception(
                                        "Workflow not found. Probably you did not save your workflow yet or it has been disabled."
                                    );
                                }

                                return RunWorkflow::invoke($workflow, $executionArguments)->toPublic();
                            } catch (\Exception $exception) {
                                return [
                                    'success' => false,
                                    'error'   => $exception->getMessage(),
                                ];
                            }
                        },
                        'permission_callback' => '__return_true',
                        'show_in_index'       => false,
                        'args'                => [],
                    ],
                    true
                );
            },
            1
        );
    }

    protected static function listenToEvent(StartupDefinition $startupDefinition)
    {
        $startupDefinition->getEvent()->handleStartupDefinition($startupDefinition);
    }

    protected static function handleForm(StartupDefinition $startupDefinition)
    {
        // @TODO: Handle when there is no form provider to handle the definition
        $startupDefinition->getFormProvider()->handleStartupDefinition($startupDefinition);
    }
}
