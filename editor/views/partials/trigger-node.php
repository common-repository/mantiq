<div class="text-center">
    <div class="bg-primary rounded-pill p-2 pe-3 d-inline-flex align-items-center text-white">
        <span class="material-icons me-2">bolt</span>
        <small><?php _e('Trigger', 'mantiq') ?></small>
    </div>
</div>
<div class="org-tree-leaf-separator"></div>
<div class="bg-white rounded border border-2 border-primary" :class="{'has-errors': node.errors.length}"
     @click="$emit('click')">
    <header class="bg-primary-light d-flex align-items-center p-2">
        <span class="material-icons text-primary me-2">{{node.trigger_type_icon}}</span>
        <small class="me-auto">{{node.trigger_type_label}}</small>
        <router-link class="btn btn-sm btn-inline text-secondary"
                     data-tooltip="<?php esc_attr_e('Settings', 'mantiq') ?>"
                     :to="{name: 'nodeSettings', params: {nodeUid: node.uid}, query: {tab: 'settings'}}">
            <span class="material-icons">settings</span>
        </router-link>
        <router-link @click.stop class="btn btn-sm btn-inline text-secondary ms-2"
                     data-tooltip="<?php esc_attr_e('Outputs', 'mantiq') ?>"
                     :to="{name: 'nodeSettings', params: {nodeUid: node.uid}, query: {tab: 'outputs'}}">
            <span class="material-icons">logout</span>
        </router-link>
        <router-link @click.stop v-if="node.errors.length" class="btn btn-sm btn-inline text-danger ms-2"
                     data-tooltip="<?php esc_attr_e('Errors', 'mantiq') ?>"
                     :to="{name: 'nodeSettings', params: {nodeUid: node.uid}, query: {tab: 'errors'}}">
            <span class="material-icons">error</span>
        </router-link>
    </header>
    <section class="p-3 border-top">
        <div class="small text-muted" v-if="node.properties.type === 'schedule'">
            <strong><?php _e('Frequency', 'mantiq') ?>:</strong> {{triggerSchedule.name}}
            <div v-if="triggerSchedule.startsAt"><strong>Starts at:</strong> {{triggerSchedule.startsAt}}</div>
        </div>
        <div class="small text-muted text-truncate" v-if="node.properties.type === 'event'">
            <strong><?php _e('On', 'mantiq') ?>:</strong> {{ triggerEvent.name }}
        </div>
        <div class="small text-muted" v-if="node.properties.type === 'webhook'">
            <div class="text-truncate d-flex align-items-center my-1 text-primary">
                <strong><?php _e('URL', 'mantiq'); ?>:</strong>
                <span class="text-truncate mx-1">{{ triggerWebhook.slug }}</span>
                <a :href="triggerWebhook.url" target="_blank" class="link-primary text-decoration-none"><span class="material-icons">open_in_new</span></a>
            </div>
            <div v-if="triggerWebhook.parameters"><strong><?php _e('Receives', 'mantiq') ?>:</strong> <small>{{ triggerWebhook.parameters }}</small></div>
        </div>
        <div class="small text-muted" v-if="node.properties.type === 'form'">
            <strong><?php _e('Form', 'mantiq') ?>:</strong> {{triggerForm.name}}
            <div v-if="triggerForm.outputs"></div>
        </div>
    </section>
</div>
