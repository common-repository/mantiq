<div class="bg-white rounded border border-2 border-dark" :class="{'has-errors': node.errors.length}" @click.stop>
    <header class="bg-dark-light d-flex align-items-center p-2">
        <span class="material-icons text-dark me-2">rule</span>
        <small class="me-auto">{{node.properties.name || '<?php _e('Condition', 'mantiq') ?>'}}</small>

        <button class="btn btn-sm btn-inline text-danger" @click.stop="remove"
                data-tooltip="<?php esc_attr_e('Delete', 'mantiq') ?>">
            <span class="material-icons">delete</span>
        </button>
        <router-link @click.stop v-if="node.errors.length" class="btn btn-sm btn-inline text-danger ms-2"
                     data-tooltip="<?php esc_attr_e('Errors', 'mantiq') ?>"
                     :to="{name: 'nodeSettings', params: {nodeUid: node.uid}, query: {tab: 'errors'}}">
            <span class="material-icons">error</span>
        </router-link>
    </header>
    <section class="p-3 border-top">
        <template v-for="(branch, index) in node.children">
            <div class="d-flex align-items-center border-bottom pb-2 mb-2">
                <router-link @click.stop
                             class="text-decoration-none me-auto"
                             :to="{name: 'nodeSettings', params: {nodeUid: branch.uid}, query: {tab: 'settings'}}">

                    <template v-if="index > 0">
                        <small>{{branch.properties.name || '<?php _e('Branch', 'mantiq') ?> #' + (index + 1)}}</small>
                        <br>
                        <small class="text-muted">{{branch.properties.conditions?.length || 0}} <?php _e('Conditions', 'mantiq') ?></small>
                    </template>
                    <template v-else>
                        <small><?php _e('Default branch', 'mantiq') ?></small>
                    </template>
                </router-link>

                <template v-if="index > 0">
                    <button class="btn btn-sm btn-inline text-danger ms-2"
                            v-if="index > 1 || node.children.length > 2"
                            @click.stop="removeBranch(branch)">
                        <span class="material-icons">delete</span>
                    </button>

                    <router-link @click.stop
                                 class="btn btn-sm btn-inline text-secondary ms-2"
                                 :to="{name: 'nodeSettings', params: {nodeUid: branch.uid}, query: {tab: 'settings'}}">
                        <span class="material-icons">settings</span>
                    </router-link>
                </template>
            </div>
        </template>
        <button class="btn btn-sm btn-inline link-primary"
                @click.stop="addBranch">
            <span class="material-icons me-2">add</span> <?php _e('Add branch', 'mantiq') ?>
        </button>
    </section>
</div>
