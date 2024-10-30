<div class="d-flex flex-column justify-content-center align-items-center py-4 h-100" v-if="isLoading">
    <div class="spinner-border mb-3" role="status">
        <span class="visually-hidden"><?php _e('Loading...', 'mantiq') ?></span>
    </div>

    <span><?php _e('Fetching the workflow...', 'mantiq') ?></span>
</div>
<template v-else>
    <div class="app-header position-relative bg-white shadow-sm d-flex align-items-center">
        <router-link to="/" class="btn btn-inline p-3 border-end rounded-0 h-100">
            <span class="material-icons">keyboard_backspace</span>
        </router-link>

        <div class="d-flex align-items-center flex-fill p-3 lh-1">
            <div class="fs-2 me-1">
                <span class="text-success material-icons" title="Activated"
                      v-if="lastEnabledState">play_circle_outline</span>
                <span class="text-muted opacity-50 material-icons" v-else
                      title="Deactivated">pause_circle_outline</span>
            </div>

            <div class="m-0 w-50">
                <input class="form-control bg-transparent border-0 p-0 fs-6 ms-2" v-model="workflow.name">
                <small class="text-muted ms-2 text-capitalize">Last updated: {{workflow.time_since_updated}}</small>
            </div>

            <div class="ms-auto d-flex align-items-center">
                <a href="https://wpmantiq.com/docs/?utm_source=in-app&utm_medium=top-menu&utm_campaign=mantiq"
                   target="_blank" class="btn btn-icon p-0 mx-2"><span
                            class="material-icons">help</span><?php _e('Help', 'mantiq') ?></a>

                <button class="btn btn-icon p-0 mx-2" @click="refreshEnv()" data-tooltip="<?php esc_attr_e('Refresh Inputs', 'mantiq') ?>">
                    <span class="material-icons">refresh</span></button>

                <router-link :to="{name: 'viewLog', params: {uid: workflow.uid}}"
                             class="btn btn-sm btn-outline-dark ms-2 py-2 px-3" tag="button"
                             type="button">
                    <?php _e('View Log', 'mantiq') ?>
                </router-link>

                <div class="btn-group ms-2">
                    <div class="form-check form-switch m-0 p-2 border border-2 rounded-start d-flex align-items-center align-self-stretch"
                         :class="{'border-primary': workflow.enabled, 'bg-light': !workflow.enabled}">
                        <input class="form-check-input m-0" id="workflow-enabled" type="checkbox"
                               v-model="workflow.enabled"/>
                        <label class="form-label m-0 ps-2 pe-1" :class="{'text-primary': workflow.enabled}"
                               for="workflow-enabled"><?php _e('Enabled', 'mantiq'); ?></label>
                    </div>

                    <button class="btn btn-sm btn-primary btn-save py-2 px-3" type="button" @click="save"
                            :disabled="isSaving">
                        <span v-if="isSaving"><?php _e('Saving...', 'mantiq') ?></span>
                        <span v-else><?php _e('Save', 'mantiq') ?></span>
                    </button>
                </div>
            </div>

        </div>
    </div>

    <variable-finder :workflow="workflow"></variable-finder>
    <div class="flex-fill overflow-auto">
        <div class="row g-0 h-100">
            <div class="col-9 d-flex flex-column h-100">
                <workflow-editor-canvas :workflow="workflow"
                                        :class="{'has-active-node': currentActiveNodes.length > 0}"></workflow-editor-canvas>
            </div>
            <aside class="col-3 d-flex flex-column h-100 border-start border-2 shadow-sm position-relative">
                <router-view v-slot="{ Component, route }">
                    <component :is="Component" :key="route.path" :workflow="workflow"></component>

                    <div v-if="route.name === 'editor'"
                         class="d-flex flex-column justify-content-center align-items-center py-4 h-100">
                        <span class="material-icons fs-1 text-muted mb-3">touch_app</span>
                        <span><?php _e('Add or select a node', 'mantiq') ?></span>
                    </div>
                </router-view>
            </aside>
        </div>
    </div>
</template>
