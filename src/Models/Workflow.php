<?php

namespace Mantiq\Models;

use Mantiq\Plugin;

/**
 * @property string type
 * @property string uid
 * @property string name
 * @property Node tree
 * @property boolean enabled
 * @property string created_at
 * @property string updated_at
 * @property string deleted_at
 */
class Workflow extends Model
{
    const SCHEDULE = 'schedule';
    const WEBHOOK  = 'webhook';
    const EVENT    = 'event';
    const FORM     = 'form';

    public function isEvent()
    {
        return $this->type === self::EVENT;
    }

    public function isWebhook()
    {
        return $this->type === self::WEBHOOK;
    }

    public function isSchedule()
    {
        return $this->type === self::SCHEDULE;
    }

    public function isForm()
    {
        return $this->type === self::FORM;
    }

    public function fromDatabase($rawAttributes)
    {
        $rawAttributes['tree']     = new Node(json_decode($rawAttributes['tree'] ?? '{}', true));
        $rawAttributes['settings'] = json_decode($rawAttributes['settings'] ?? '{}', true);
        $rawAttributes['enabled']  = (bool) ($rawAttributes['enabled'] ?? false);

        return $rawAttributes;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        $attributes = parent::jsonSerialize();

        if ($this->isSchedule() && $attributes['enabled']) {
            $attributes['_next_run_at'] = wp_date(DATE_ATOM, wp_next_scheduled($this->getScheduleHookName()));
        }

        if ($attributes['last_run_at']) {
            $attributes['last_run_at'] = wp_date(DATE_ATOM, strtotime($this['last_run_at']));
        }

        if ($attributes['updated_at']) {
            $attributes['updated_at'] = wp_date(DATE_ATOM, strtotime($this['updated_at']));
        }

        return $attributes;
    }

    public function getScheduleId()
    {
        return $this['tree.properties.arguments.schedule.frequency'];
    }

    public function getScheduleHookName()
    {
        return Plugin::prefix($this->uid);
    }

    public function getWebhookHookName()
    {
        return Plugin::prefix($this->getWebhookSlug());
    }

    public function getWebhookSlug()
    {
        return $this['tree.properties.arguments.webhook.slug'] ?: $this->uid;
    }

    public function getWebhookParameters()
    {
        return $this['tree.properties.arguments.webhook.parameters'] ?: [];
    }

    public function getEventId()
    {
        return $this['tree.properties.arguments.event.id'];
    }

    public function getEventHookName()
    {
        $eventId = $this->getEventId();

        return $eventId === 'custom' ? $this['tree.properties.arguments.event.customEvent'] : $eventId;
    }

    public function getFormProviderId()
    {
        return $this['tree.properties.arguments.form.providerId'];
    }

    public function getFormUid()
    {
        return $this['tree.properties.arguments.form.uid'];
    }

    public function getFormId()
    {
        return $this['tree.properties.arguments.form.id'];
    }

    public function isDebuggingEnabled()
    {
        return defined('WP_DEBUG') && WP_DEBUG;
    }
}
