<?php

namespace Mantiq\Models;

use Mantiq\Services\TriggersRegistry;

class ExecutionArguments extends Model
{

    public static function fromRoute(StartupDefinition $startupDefinition, \WP_REST_Request $request)
    {
        $arguments = array_map(
            static function ($parameter) use ($request) {
                $value = $request->get_param($parameter['id']);

                if (!empty($parameter['required']) && !$request->has_param($parameter['id'])) {
                    throw new \Exception(
                        sprintf(
                            "Parameter %s (%s) is required.",
                            $parameter['name'],
                            $parameter['id']
                        )
                    );
                }

                if (($parameter['type']['id'] === 'string') && $value !== null && !is_string($value)) {
                    throw new \Exception(
                        sprintf(
                            "Parameter %s (%s) should be a string.",
                            $parameter['name'],
                            $parameter['id']
                        )
                    );
                }

                if ($parameter['type']['id'] === 'number') {
                    if ($value !== null && !is_numeric($value)) {
                        throw new \Exception(
                            sprintf(
                                "Parameter %s (%s) should be a number.",
                                $parameter['name'],
                                $parameter['id']
                            )
                        );
                    }

                    $value = (int) $value;
                }

                if ($value !== null && $parameter['type']['id'] === 'boolean') {
                    $value = wp_validate_boolean($value);
                }

                return $value;
            },
            $startupDefinition['arguments.parameters']
        );

        return new self($arguments);
    }

    public static function fromEvent(StartupDefinition $startupDefinition, $args)
    {
        $event = TriggersRegistry::instance()->getEvent(
            $startupDefinition['arguments.eventId'] ?? $startupDefinition['arguments.hookName']
        );

        if ($event) {
            $args = $event->getNamedArgumentsFromRawEvent($args);
        }

        return new self($args);
    }

    public static function fromForm(StartupDefinition $startupDefinition, $args)
    {
        return new self($args);
    }

    public static function fromScheduledEvent(StartupDefinition $startupDefinition, $args)
    {
        $args['time'] = time();

        return new self($args);
    }
}
