<label class="form-label mb-3"><?php _e('What should trigger it?', 'mantiq') ?></label>

<div class="form-check mb-3" v-for="(triggerType, triggerId) in triggerTypes">
    <input class="form-check-input"
           type="radio"
           :id="'setting-trigger-' + triggerId"
           :value="triggerId"
           v-model="node.properties.type">
    <label class="form-check-label" :for="'setting-trigger-' + triggerId">
        <span class="">{{ triggerType.label }}</span>
        <span class="material-icons mx-2"
              :class="[node.properties.type === triggerId ? 'text-primary' : 'text-secondary']">{{ triggerType.icon }}</span>
        <br>
        <small class="text-muted">{{ triggerType.description }}</small>
    </label>
</div>

<hr>

<template v-if="node.properties.type === 'schedule'">
    <div class="mb-3">
        <label for="setting-frequency" class="form-label"><?php _e("What's the frequency of it?", 'mantiq') ?></label>
        <div class="form-check" v-for="triggerSchedule in triggerSchedules">
            <input class="form-check-input"
                   type="radio"
                   :id="'setting-frequency-' + triggerSchedule.id"
                   :value="triggerSchedule.id"
                   v-model="node.property('arguments.schedule').frequency">
            <label class="form-check-label" :for="'setting-frequency-' + triggerSchedule.id">{{ triggerSchedule.name
                }}</label>
        </div>
    </div>
    <div class="mb-3">
        <label for="setting-frequency-start-date" class="form-label"><?php _e(
                'When it should starts?',
                'mantiq'
            ) ?></label>
        <input type="datetime-local"
               class="form-control"
               id="setting-frequency-start-date"
               v-model="node.property('arguments.schedule').startDate"/>
    </div>
</template>

<template v-else-if="node.properties.type === 'event'">
    <error-wrapper class="mb-3" group="event-name" v-slot="{errors}">
        <label for="setting-event-name" class="form-label">
            <?php _e('What event should trigger it?', 'mantiq') ?>
        </label>

        <multiselect :options="eventGroups"
                     :groups="true"
                     group-label="name"
                     group-options="events"
                     value-prop="id"
                     trackBy="name"
                     v-model="node.property('arguments.event').id"
                     :searchable="true"
                     :strict="false"
                     :native-support="true"
                     :close-on-select="true"
                     label="name"
                     :class="{'is-invalid': errors.length}">
            <template v-slot:singlelabel="{ value }">
                <div class="multiselect-single-label justify-content-center align-items-start flex-column flex-fill">
                    <small class="text-truncate text-muted"><span class="small">{{ value.group }}</span></small>
                    <span class="text-truncate text-primary">{{ value.name }}</span>
                </div>
            </template>
        </multiselect>

        <p class="invalid-feedback" v-for="error in errors">{{ error.message }}</p>
    </error-wrapper>
    <error-wrapper v-if="node.property('arguments.event').id === 'custom'"
                   class="mb-3"
                   group="custom-event-name"
                   v-slot="{errors}">
        <label for="setting-event-custom" class="form-label"><?php _e(
                'What is the custom event name?',
                'mantiq'
            ) ?></label>
        <input type="text" id="setting-event-custom"
               class="form-control"
               :class="{'is-invalid': errors.length}"
               placeholder="<?php esc_attr_e('Custom event name...', 'mantiq') ?>"
               v-model="node.property('arguments.event').customEvent">
        <p class="invalid-feedback" v-for="error in errors">{{ error.message }}</p>
    </error-wrapper>
    <div v-if="node.property('arguments.event').id !== 'custom'">
        <component :is="node.event_component"
                   :node="node"
                   :arguments="node.property('arguments.' + node.property('arguments.event').id)"></component>
    </div>
</template>

<template v-else-if="node.properties.type === 'webhook'">
    <error-wrapper class="mb-3" group="webhook-slug" v-slot="{errors}">
        <label for="setting-webhook-slug" class="form-label"><?php _e('Slug', 'mantiq') ?></label>

        <input type="text" id="setting-webhook-slug"
               class="form-control form-control-sm"
               placeholder="<?php esc_attr_e('WebHook URL...', 'mantiq') ?>"
               :class="{'is-invalid': errors.length}"
               v-model="webhookSlug">
        <p v-if="!errors.length" class="small text-truncate d-flex align-items-center my-1 text-primary">
            <span class="text-truncate">{{node.webhook_url}}</span>
            <a :href="node.webhook_url" target="_blank" class="link-primary text-decoration-none"><span
                        class="material-icons">open_in_new</span></a>
        </p>
        <p class="invalid-feedback" v-for="error in errors">{{ error.message }}</p>
    </error-wrapper>
    <div class="mb-3">
        <label for="setting-webhook-params" class="form-label"><?php _e('Parameters', 'mantiq') ?></label>
        <parameters-composer :node="node"
                             :parameters="node.property('arguments.webhook.parameters', {})"></parameters-composer>
    </div>
</template>

<template v-else-if="node.properties.type === 'form'">
    <error-wrapper class="mb-3" group="form-trigger" v-slot="{errors}">
        <label for="setting-form-name" class="form-label d-flex align-items-center">
            <?php _e('What form should trigger it?', 'mantiq') ?>

            <?php
            $newFormUrl = 'admin.php?page=totalform';

            if (!Mantiq\Plugin::isPluginActive('totalform/plugin.php')) {
                $newFormUrl = 'plugin-install.php?s=totalform&tab=search&type=term';
            }
            ?>
            <a target="_blank" href="<?php echo esc_attr(admin_url($newFormUrl)); ?>"
               class="btn-inline small btn-link text-decoration-none ms-auto" role="button">
                <span class="material-icons me-1">add</span> <?php _e('New form', 'mantiq') ?>
            </a>
        </label>

        <multiselect :options="formProviders"
                     :groups="true"
                     group-label="name"
                     group-options="forms"
                     value-prop="uid"
                     trackBy="name"
                     :object="true"
                     v-model="node.property('arguments').form"
                     :searchable="true"
                     :strict="false"
                     :native-support="true"
                     :close-on-select="true"
                     label="name"
                     :class="{'is-invalid': errors.length}">
            <template v-slot:singlelabel="{ value }">
                <div class="multiselect-single-label justify-content-center align-items-start flex-column flex-fill">
                    <small class="text-truncate text-muted"><span class="small">{{ value.provider }}</span></small>
                    <span class="text-truncate text-primary">{{ value.name }}</span>
                </div>
            </template>
        </multiselect>

        <table class="table table-borderless mt-3" v-if="formFields.length">
            <thead>
            <tr class="bg-primary-light">
                <th class="fw-light w-50">Field</th>
                <th class="fw-light text-center">Required</th>
            </tr>
            </thead>
            <tbody>
            <tr class="align-middle" v-for="field in formFields">
                <td class="small"><span>{{ field.name }}</span></td>
                <td class="text-center">
                    <div class="material-icons" v-if="field.required">check</div>
                </td>
            </tr>
            </tbody>
        </table>

        <p class="invalid-feedback" v-for="error in errors">{{ error.message }}</p>
    </error-wrapper>
</template>
