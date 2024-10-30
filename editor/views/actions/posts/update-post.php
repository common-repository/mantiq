<div class="row gy-3">
    <div class="col-12">
        <label for="post-id" class="form-label"><?php _e('Post ID', 'mantiq'); ?></label>

        <reference-input-helper :single="true">
            <input type="text"
                   id="post-id"
                   class="form-control form-control-sm"
                   placeholder="<?php _e('Post ID, Post slug...', 'mantiq'); ?>"
                   v-model="arguments.id"
                   v-variable-finder-trigger>
        </reference-input-helper>
    </div>

    <div class="col-12">
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" role="switch" id="update-title"
                   v-model="arguments.updateTitle">
            <label class="form-check-label form-label" for="update-title">
                <?php _e('Title', 'mantiq'); ?>
            </label>
        </div>

        <reference-input-helper v-if="arguments.updateTitle">
            <input type="text"
                   id="post-title"
                   class="form-control form-control-sm"
                   placeholder="<?php _e('Post title...', 'mantiq'); ?>"
                   v-model="arguments.title"
                   v-variable-finder-trigger>
        </reference-input-helper>
    </div>

    <div class="col-12" :class="{'mt-0': !arguments.updateTitle}">
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" role="switch" id="update-content"
                   v-model="arguments.updateContent">
            <label class="form-check-label form-label" for="update-content">
                <?php _e('Content', 'mantiq'); ?>
            </label>
        </div>

        <reference-input-helper v-if="arguments.updateContent">
                    <textarea id="post-content"
                              class="form-control form-control-sm"
                              placeholder="<?php _e('Post content...', 'mantiq'); ?>"
                              rows="4"
                              v-model="arguments.content" v-variable-finder-trigger></textarea>
        </reference-input-helper>
    </div>

    <div class="col-12" :class="{'mt-0': !arguments.updateContent}">
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" role="switch" id="update-status"
                   v-model="arguments.updateStatus">
            <label class="form-check-label form-label" for="update-status">
                <?php _e('Status', 'mantiq'); ?>
            </label>
        </div>

        <template v-if="arguments.updateStatus">
            <?php foreach (get_post_statuses() as $postStatusId => $postStatusLabel): ?>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="post-status"
                           id="post-status-<?php echo esc_attr($postStatusId); ?>" v-model="arguments.status"
                           value="<?php echo esc_attr($postStatusId); ?>">
                    <label class="form-check-label" for="post-status-<?php echo esc_attr($postStatusId); ?>">
                        <?php echo esc_html($postStatusLabel); ?>
                    </label>
                </div>
            <?php endforeach; ?>
        </template>
    </div>

    <div class="col-12" :class="{'mt-0': !arguments.updateStatus}">
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" role="switch" id="update-author"
                   v-model="arguments.updateAuthor">
            <label class="form-check-label form-label" for="update-author">
                <?php _e('Author', 'mantiq'); ?>
            </label>
        </div>

        <reference-input-helper v-if="arguments.updateAuthor">
            <input type="text"
                   id="post-author"
                   class="form-control form-control-sm"
                   placeholder="<?php _e('User id, username, or email...', 'mantiq'); ?>"
                   v-model="arguments.author"
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
                   href="https://developer.wordpress.org/reference/functions/wp_update_post/#parameters"><?php _e(
                        'Docs',
                        'mantiq'
                    ); ?> <span
                            class="material-icons">open_in_new</span></a>
            </summary>

            <json-editor id="post-arguments" v-model="arguments.customArguments"></json-editor>
        </details>
    </div>
</div>
