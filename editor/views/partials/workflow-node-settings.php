<div class="h-100 overflow-auto d-flex flex-column" v-if="node">
    <nav class="d-flex shadow-sm">
        <router-link :class="[tab === 'settings' ? 'text-primary border-primary bg-primary-light' : 'text-dark']"
                     class="d-flex align-items-center justify-content-center flex-fill text-decoration-none py-3 border-bottom border-2"
                     :to="{path: '', query: {tab: 'settings'}}">
            <span class="fs-5 material-icons me-2">settings</span>
            <?php _e('Settings', 'mantiq') ?>
        </router-link>

        <span class="border-end"></span>

        <router-link v-if="node.outputs_component"
                     :class="[tab === 'outputs' ? 'text-primary border-primary bg-primary-light' : 'text-dark']"
                     class="d-flex align-items-center justify-content-center flex-fill text-decoration-none py-3 border-bottom border-2"
                     :to="{path: '', query: {tab: 'outputs'}}">
            <span class="fs-5 material-icons me-2">logout</span>
            <?php _e('Outputs', 'mantiq') ?>
            <span class="badge rounded-pill bg-primary ms-2 fw-normal">{{node.outputs.length}}</span>
        </router-link>

        <span class="border-end"></span>

        <router-link
                     :class="[tab === 'log' ? 'text-primary border-primary bg-primary-light' : 'text-dark']"
                     class="d-flex align-items-center justify-content-center flex-fill text-decoration-none py-3 border-bottom border-2"
                     :to="{path: '', query: {tab: 'log'}}">
            <span class="fs-5 material-icons">receipt_long</span>
        </router-link>

        <span class="border-end"></span>

        <router-link v-if="node.errors.length"
                     :class="[tab === 'errors' ? 'border-danger bg-danger-light' : '']"
                     class="d-flex align-items-center justify-content-center flex-fill text-danger text-decoration-none py-3 border-bottom border-2"
                     :to="{path: '', query: {tab: 'errors'}}">
            <span class="badge rounded-pill bg-danger me-2 fw-normal">{{node.errors.length}}</span>
            <?php _e('Errors', 'mantiq') ?>
        </router-link>
    </nav>
    <div class="flex-fill overflow-hidden">
        <div class="h-100 overflow-auto custom-scrollbars" :class="{'p-4': tab !== 'log'}">
            <component v-if="tab === 'settings'" :is="node.settings_component" :node="node" :key="node.uid"/>
            <component v-if="tab === 'outputs'" :is="node.outputs_component" :outputs="node.outputs" :key="node.uid"/>
            <component v-if="tab === 'errors'" :is="node.errors_component" :errors="node.errors" :key="node.uid"/>
            <workflow-log v-if="tab === 'log'" :uid="workflow.uid" :workflow="workflow" :node="node" :key="node.uid"/>
        </div>
    </div>
</div>
