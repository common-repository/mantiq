<div class="app-header position-relative p-3 bg-white shadow-sm">
    <div class="container-fluid d-flex align-items-center ">
        <router-link to="/">
            <img width="100"
                 height="30"
                 src="<?php echo \Mantiq\Plugin::getUrl('assets/images/logo.svg') ?>"
                 alt="Mantiq">
        </router-link>

        <div class="ms-3 ps-3 border-start">
            <button class="btn btn-sm btn-icon btn-primary rounded-pill pe-3" @click="create()">
                <span class="material-icons">add</span>
                <?php _e('New', 'mantiq') ?>
            </button>
            <router-link :to="{name: 'import'}"
                         class="btn btn-sm btn-icon btn-outline-secondary rounded-pill pe-3 ms-2">
                <span class="material-icons">backup</span>
                <?php _e('Import', 'mantiq') ?>
            </router-link>

            <router-link :to="{name: 'integrations'}"
                         class="btn btn-sm btn-icon btn-outline-primary rounded-pill pe-3 ms-2">
                <span class="material-icons">extension</span>
                <?php _e('Integrations', 'mantiq') ?>
            </router-link>
        </div>

        <span class="ms-auto"></span>
        <router-link :to="{name: 'what-is-new'}" class="btn btn-sm btn-icon text-dark p-0">
            <span class="material-icons">campaign</span>What's new
        </router-link>
        <a href="https://wpmantiq.com/feedback/?utm_source=in-app&utm_medium=top-menu&utm_campaign=mantiq"
           target="_blank"
           class="btn btn-sm btn-icon text-dark p-0 ms-3">
            <span class="material-icons">forum</span>Feedback
        </a>
        <a href="https://wpmantiq.com/community/?utm_source=in-app&utm_medium=top-menu&utm_campaign=mantiq"
           target="_blank"
           class="btn btn-sm btn-icon text-dark p-0 ms-3">
            <span class="material-icons">group</span>Community
        </a>
        <a href="https://wpmantiq.com/docs/?utm_source=in-app&utm_medium=top-menu&utm_campaign=mantiq"
           target="_blank"
           class="btn btn-sm btn-icon text-dark p-0 ms-3">
            <span class="material-icons">help</span>Help
        </a>
    </div>
</div>
<div class="py-3 h-100 bg-primary-light overflow-auto">
    <div class="container">
        <div class="d-flex flex-column justify-content-center align-items-center py-4" v-if="isLoading">
            <div class="spinner-border mb-3" role="status">
                <span class="visually-hidden"><?php _e('Loading...', 'mantiq') ?></span>
            </div>

            <span><?php _e('Fetching workflows...', 'mantiq') ?></span>
        </div>
        <template v-if="isLoaded">
            <table class="table">
                <thead>
                <tr>
                    <th class="fw-normal px-0 py-3"><?php _e('Workflow', 'mantiq') ?></th>
                    <th class="fw-normal px-0 py-3 text-center"><?php _e('Type', 'mantiq') ?></th>
                    <th class="fw-normal px-0 py-3 text-center"><?php _e('Last run', 'mantiq') ?></th>
                    <th class="fw-normal px-0 py-3 text-center"><?php _e('Next run', 'mantiq') ?></th>
                </tr>
                </thead>
                <tbody>
                <tr v-if="workflows.length == 0">
                    <td colspan="4" class="bg-white p-4">
                        <?php _e('No workflows yet.', 'mantiq') ?>
                        <span role="button" class="text-primary" @click="create()"><?php _e(
                                'Create a Workflow',
                                'mantiq'
                            ) ?> <span
                                    class="material-icons">navigate_next</span></span>
                    </td>
                </tr>
                <tr class="align-middle opacity-on-hover bg-white shadow-sm"
                    v-for="workflow in workflows"
                    :key="workflow.uid">
                    <td class="col p-0">
                        <div class="border-start border-5 p-3" :class="{'border-primary': workflow.enabled}">
                            <div class="form-check form-switch border-1">
                                <input class="form-check-input" type="checkbox" :checked="workflow.enabled"
                                       @change="toggleEnable(workflow)"/>
                                <router-link :to="{name: 'editor', params: {uid: workflow.uid}}"
                                             class="text-decoration-none"
                                             :class="{'text-dark':!workflow.enabled}">
                                    <label role="button"
                                           class="form-check-label d-inline-flex align-items-center fs-6 ps-1 lh-1">
                                        {{workflow.name}}
                                    </label>
                                </router-link>
                                <br>
                                <div class="d-flex align-items-center ps-1 pt-2 position-relative small">
                                <span class="text-muted text-capitalize"
                                      :title="workflow.updated_at">Updated <span
                                            class="text-lowercase">{{workflow.time_since_updated}}</span></span>
                                    <div class="d-flex align-items-center small show-on-hover position-absolute start-0 bg-white text-nowrap pt-1">
                                        <router-link :to="{name: 'editor', params: {uid: workflow.uid}}"
                                                     class="btn btn-sm btn-inline btn-icon">
                                            <span class="material-icons">settings</span>
                                            <?php _e('Edit', 'mantiq') ?>
                                        </router-link>
                                        <span class="border-end mx-2">&nbsp;</span>
                                        <button class="btn btn-sm btn-inline btn-icon" @click="duplicate(workflow)">
                                            <span class="material-icons">content_copy</span>
                                            <?php _e('Duplicate', 'mantiq') ?>
                                        </button>
                                        <span class="border-end mx-2">&nbsp;</span>
                                        <router-link :to="{name: 'viewLog', params: {uid: workflow.uid}}"
                                                     class="btn btn-sm btn-inline btn-icon">
                                            <span class="material-icons">receipt_long</span>
                                            <?php _e('View logs', 'mantiq') ?>
                                        </router-link>
                                        <span class="border-end mx-2">&nbsp;</span>
                                        <button @click="download(workflow)"
                                                class="btn btn-sm btn-inline btn-icon">
                                            <span class="material-icons">save_alt</span>
                                            <?php _e('Export', 'mantiq') ?>
                                        </button>
                                        <span class="border-end mx-2">&nbsp;</span>
                                        <button class="btn btn-sm btn-inline text-danger btn-icon"
                                                @click="trash(workflow)">
                                            <span class="material-icons">delete</span>
                                            <?php _e('Delete', 'mantiq') ?>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="text-secondary small col-1">
                        <div class="d-inline-flex align-items-center">
                            <span class="material-icons">{{workflow.trigger_type_icon}}</span>
                            <span class="ms-2">{{workflow.trigger_type_label}}</span>
                        </div>
                    </td>
                    <td class="px-2 small text-center text-capitalize text-nowrap col-1" :title="workflow.last_run_at">
                        {{workflow.time_since_last_run || '—'}}
                    </td>
                    <td class="px-2 small text-center text-capitalize text-nowrap col-1" :title="workflow.next_run_at">
                        {{workflow.time_until_next_run || '—'}}
                    </td>
                </tr>
                </tbody>
            </table>
        </template>
    </div>
</div>

<router-view></router-view>
