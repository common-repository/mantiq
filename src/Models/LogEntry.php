<?php

namespace Mantiq\Models;

use Mantiq\Support\Collection;

/**
 * @property string invocation_uid
 * @property string workflow_uid
 * @property string node_uid
 * @property string level
 * @property string message
 * @property Collection context
 * @property string logged_at
 */
class LogEntry extends Model
{
    public function fromDatabase($rawAttributes)
    {
        $rawAttributes['context'] = json_decode($rawAttributes['context'] ?? '{}', true);

        return $rawAttributes;
    }
    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        $attributes = parent::jsonSerialize();

        if ($attributes['logged_at']) {
            $attributes['logged_at'] = wp_date(DATE_ATOM, strtotime($this['logged_at']));
        }

        return $attributes;
    }
}
