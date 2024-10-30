<div class="bg-white rounded border border-2 border-warning" :class="{'has-errors': node.errors.length}"
     @click="$emit('click')">
    <header class="bg-warning-light d-flex align-items-center p-2">
        <span class="material-icons text-warning me-2">{{ node.type_icon }}</span>
        <small class="me-auto">{{ node.type_label }}</small>

        <button class="btn btn-sm btn-inline text-danger" @click.stop="remove"
                data-tooltip="<?php esc_attr_e('Delete', 'mantiq') ?>">
            <span class="material-icons">delete</span>
        </button>
        <router-link @click.stop class="btn btn-sm btn-inline text-secondary ms-2"
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
        <div class="small text-muted" v-for="variable in variables">
            {{ variable.name || variable.id || 'Undefined variable' }} → <code>{{ variable.value || 'Undefined value'
                }}</code></div>
        <small class="text-muted" v-if="variables.length === 0"><?php _e('No assignments yet.', 'mantiq') ?></small>
    </section>
</div>
