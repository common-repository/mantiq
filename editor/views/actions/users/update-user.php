<div class="row gy-3">
    <div class="col-12">
        <label for="user-id" class="form-label"><?php _e('User ID', 'mantiq'); ?></label>

        <reference-input-helper :single="true">
            <input type="text"
                   id="user-id"
                   class="form-control form-control-sm"
                   placeholder="<?php _e('User ID, Username, User email...', 'mantiq'); ?>"
                   v-model="arguments.id"
                   v-variable-finder-trigger>
        </reference-input-helper>
    </div>

    <div class="col-12">
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" role="switch" id="update-username"
                   v-model="arguments.updateUsername">
            <label class="form-check-label form-label" for="update-username">
                <?php _e('Username', 'mantiq'); ?>
            </label>
        </div>

        <reference-input-helper v-if="arguments.updateUsername">
            <input type="text"
                   id="user-name"
                   class="form-control form-control-sm"
                   placeholder="<?php _e('Username...', 'mantiq'); ?>"
                   v-model="arguments.username"
                   v-variable-finder-trigger>
        </reference-input-helper>
    </div>

    <div class="col-12" :class="{'mt-0': !arguments.updateUsername}">
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" role="switch" id="update-email"
                   v-model="arguments.updateEmail">
            <label class="form-check-label form-label" for="update-email">
                <?php _e('Email', 'mantiq'); ?>
            </label>
        </div>

        <reference-input-helper v-if="arguments.updateEmail">
            <input type="text"
                   id="user-email"
                   class="form-control form-control-sm"
                   placeholder="<?php _e('User email...', 'mantiq'); ?>"
                   v-model="arguments.email"
                   v-variable-finder-trigger>
        </reference-input-helper>
    </div>

    <div class="col-12" :class="{'mt-0': !arguments.updateEmail}">
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" role="switch" id="update-role"
                   v-model="arguments.updateRole">
            <label class="form-check-label form-label" for="update-role">
                <?php _e('Role', 'mantiq'); ?>
            </label>
        </div>

        <template v-if="arguments.updateRole">
            <?php foreach (get_editable_roles() as $roleId => $role): ?>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="user-role"
                           id="user-role-<?php echo esc_attr($roleId); ?>" v-model="arguments.role"
                           value="<?php echo esc_attr($roleId); ?>">
                    <label class="form-check-label" for="user-role-<?php echo esc_attr($roleId); ?>">
                        <?php echo esc_html($role['name']); ?>
                    </label>
                </div>
            <?php endforeach; ?>
        </template>
    </div>

    <div class="col-12" :class="{'mt-0': !arguments.updateRole}">
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" role="switch" id="update-password"
                   v-model="arguments.updatePassword">
            <label class="form-check-label form-label" for="update-password">
                <?php _e('Password', 'mantiq'); ?>
            </label>
        </div>

        <reference-input-helper v-if="arguments.updatePassword">
            <input type="text"
                   id="user-password"
                   class="form-control form-control-sm"
                   placeholder="<?php _e('User password...', 'mantiq'); ?>"
                   v-model="arguments.password"
                   v-variable-finder-trigger>
        </reference-input-helper>
    </div>

    <div class="col-12 d-flex align-items-center pt-3">
        <small class="text-uppercase text-primary"><?php _e('Advanced users zone', 'mantiq'); ?></small>
        <div class="border-bottom border-primary flex-fill ms-3"></div>
    </div>

    <div class="col-12">
        <details :open="arguments.customArguments ? true : undefined">
            <summary class="d-flex align-items-center form-label">
                <span><?php _e('Extra arguments', 'mantiq'); ?></span>
                <span class="badge bg-primary rounded-pill ms-2 fw-normal">JSON</span>
                <a class="ms-auto text-decoration-none small" target="_blank"
                   href="https://developer.wordpress.org/reference/functions/wp_update_user/#parameters"><?php _e(
                        'Docs',
                        'mantiq'
                    ); ?> <span
                            class="material-icons">open_in_new</span></a>
            </summary>

            <json-editor id="user-arguments" v-model="arguments.customArguments"></json-editor>
        </details>
    </div>
</div>
