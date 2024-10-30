<div class="form-label d-flex align-items-center">
    <?php _e('Connection', 'mantiq'); ?>

    <a class="btn-inline small btn-link text-decoration-none ms-auto"
       role="button"
       @click="connect">
        <template v-if="isLoading">
            <span class="material-icons me-1">autorenew</span>
            <?php _e('Connecting', 'mantiq'); ?>
        </template>
        <template v-else>
            <span class="material-icons me-1">add</span>
            <?php _e('Connect', 'mantiq'); ?>
        </template>
    </a>
</div>

<multiselect :options="connections"
             value-prop="uid"
             trackBy="uid"
             v-model="modelValue"
             :searchable="true"
             :strict="false"
             :native-support="true"
             :close-on-select="true"
             id="connection"
             label="label">
    <template v-slot:singlelabel="{ value }">
        <div class="multiselect-single-label justify-content-center align-items-start flex-column flex-fill">
            <small class="text-truncate text-muted"><span class="small">{{ value.id }}</span></small>
            <span class="text-truncate text-primary">{{ value.label }}</span>
        </div>
        <span class="material-icons text-danger zi-1 mx-2" v-if="value.expired_at"
              title="Expired. Click to renew it." @click.stop="connect">sync_problem</span>
    </template>
    <template v-slot:option="{ option }">
        <div class="d-flex flex-column">
            {{ option.label }}
            <small class="opacity-75 text-truncate">{{ option.id }}</small>
        </div>
        <span class="material-icons text-danger ms-auto" v-if="option.expired_at"
              title="<?php esc_attr_e('Expired. Click to renew it.', 'mantiq'); ?>"
              @click.stop="connect">sync_problem</span>
    </template>
</multiselect>

<div class="d-flex align-items-center text-dark small p-2 rounded bg-warning-light mt-1 mb-3">
    <span class="material-icons me-2">info</span>
    <small class="d-flex flex-fill"><?php _e('Credentials are stored on your website.', 'mantiq') ?>
        <a href="#" class="text-decoration-none ms-auto"><?php _e('Learn more', 'mantiq'); ?></a>
    </small>
</div>

<slot v-if="isSelectedConnectionValid" v-bind="{connection}" name="validConnection"></slot>
