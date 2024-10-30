<div class="row gy-3">
    <div class="col-12">
        <label for="action-name" class="form-label"><?php _e('Name', 'mantiq') ?></label>

        <input type="text" id="action-name"
               class="form-control form-control-sm"
               placeholder="<?php esc_attr_e('Action name...', 'mantiq') ?>"
               v-model="actionName">

        <div class="small mt-1 text-muted" v-if="!actionName"><?php _e(
                'Name this action to reference it easily.',
                'mantiq'
            ) ?></div>
    </div>

    <div class="col-12">
        <label for="action-id" class="form-label text-primary"><?php _e('Action', 'mantiq') ?></label>

        <!--        <select class="form-select form-select-sm text-primary"-->
        <!--                id="action-id"-->
        <!--                v-model="node.properties.id">-->
        <!--            <optgroup :label="group.name" v-for="group in actionsGroups">-->
        <!--                <option :value="action.id" v-for="action in group.actions">{{ action.name }}</option>-->
        <!--            </optgroup>-->
        <!--        </select>-->

        <multiselect :options="actionsGroups"
                     :groups="true"
                     group-label="name"
                     group-options="actions"
                     value-prop="id"
                     trackBy="name"
                     v-model="node.properties.id"
                     :searchable="true"
                     :strict="false"
                     :native-support="true"
                     :close-on-select="true"
                     label="name">
            <template v-slot:singlelabel="{ value }">
                <div class="multiselect-single-label justify-content-center align-items-start flex-column flex-fill">
                    <small class="text-truncate text-muted"><span class="small">{{ value.group }}</span></small>
                    <span class="text-truncate text-primary">{{ value.name }}</span>
                </div>
            </template>
        </multiselect>
    </div>

    <div class="col-12" v-if="node.properties.id">
        <component :is="node.action_component" :node="node"
                   :arguments="node.property('arguments.' + node.properties.id)"></component>
    </div>
</div>

