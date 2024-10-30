<div class="row gy-3">
    <div class="col-12">
        <label for="user-name" class="form-label"><?php _e('Username', 'mantiq'); ?></label>

        <reference-input-helper>
            <input type="text"
                   id="user-name"
                   class="form-control form-control-sm"
                   placeholder="<?php _e('Username...', 'mantiq'); ?>"
                   v-model="arguments.username"
                   v-variable-finder-trigger>
        </reference-input-helper>
    </div>

    <div class="col-12">
        <label for="user-email" class="form-label"><?php _e('Email', 'mantiq'); ?></label>

        <reference-input-helper>
            <input type="text"
                   id="user-email"
                   class="form-control form-control-sm"
                   placeholder="<?php _e('Email...', 'mantiq'); ?>"
                   v-model="arguments.email"
                   v-variable-finder-trigger>
        </reference-input-helper>
    </div>

    <div class="col-12">
        <label for="user-password" class="form-label"><?php _e('Password', 'mantiq'); ?></label>

        <reference-input-helper>
            <input type="text"
                   id="user-password"
                   class="form-control form-control-sm"
                   placeholder="<?php _e('Password...', 'mantiq'); ?>"
                   v-model="arguments.password"
                   v-variable-finder-trigger>
        </reference-input-helper>
        <small class="small text-warning" v-if="!arguments.password"><?php _e('An auto-generated password will be used if empty.', 'mantiq'); ?></small>
    </div>

    <div class="col-12">
        <label for="user-role" class="form-label"><?php _e('Role', 'mantiq'); ?></label>
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
                   href="https://developer.wordpress.org/reference/functions/wp_create_user/#parameters"><?php _e('Docs', 'mantiq'); ?> <span
                            class="material-icons">open_in_new</span></a>
            </summary>

            <json-editor id="user-arguments" v-model="arguments.customArguments"></json-editor>
        </details>
    </div>
</div>
