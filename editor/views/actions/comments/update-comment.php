<div class="row gy-3">
    <div class="col-12">
        <label for="comment-id" class="form-label"><?php _e('Comment ID', 'mantiq'); ?></label>

        <reference-input-helper :single="true">
            <input type="text"
                   id="comment-id"
                   class="form-control form-control-sm"
                   placeholder="<?php _e('Comment ID...', 'mantiq'); ?>"
                   v-model="arguments.id"
                   v-variable-finder-trigger>
        </reference-input-helper>
    </div>

    <div class="col-12">
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" role="switch" id="update-author-name"
                   v-model="arguments.updateAuthorName">
            <label class="form-check-label form-label" for="update-author-name">
                <?php _e('Author name', 'mantiq'); ?>
            </label>
        </div>

        <reference-input-helper v-if="arguments.updateAuthorName">
            <input type="text"
                   id="comment-author-name"
                   class="form-control form-control-sm"
                   placeholder="<?php _e('Comment author name...', 'mantiq'); ?>"
                   v-model="arguments.name"
                   v-variable-finder-trigger>
        </reference-input-helper>
    </div>

    <div class="col-12" :class="{'mt-0': !arguments.updateAuthorName}">
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" role="switch" id="update-author-email"
                   v-model="arguments.updateAuthorEmail">
            <label class="form-check-label form-label" for="update-author-email">
                <?php _e('Author email', 'mantiq'); ?>
            </label>
        </div>

        <reference-input-helper v-if="arguments.updateAuthorEmail">
            <input type="text"
                   id="comment-author-email"
                   class="form-control form-control-sm"
                   placeholder="<?php _e('Comment author email...', 'mantiq'); ?>"
                   v-model="arguments.name"
                   v-variable-finder-trigger>
        </reference-input-helper>
    </div>

    <div class="col-12" :class="{'mt-0': !arguments.updateAuthorEmail}">
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" role="switch" id="update-content"
                   v-model="arguments.updateContent">
            <label class="form-check-label form-label" for="update-content">
                <?php _e('Content', 'mantiq'); ?>
            </label>
        </div>

        <reference-input-helper v-if="arguments.updateContent">
                    <textarea id="comment-content"
                              class="form-control form-control-sm"
                              placeholder="<?php _e('Comment content...', 'mantiq'); ?>"
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
            <?php foreach (get_comment_statuses() as $commentStatusId => $commentStatusLabel): ?>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="comment-status"
                           id="comment-status-<?php echo esc_attr($commentStatusId); ?>" v-model="arguments.status"
                           value="<?php echo esc_attr($commentStatusId); ?>">
                    <label class="form-check-label" for="comment-status-<?php echo esc_attr($commentStatusId); ?>">
                        <?php echo esc_html($commentStatusLabel); ?>
                    </label>
                </div>
            <?php endforeach; ?>
        </template>
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
                   href="https://developer.wordpress.org/reference/functions/wp_update_comment/#parameters"><?php _e(
                        'Docs',
                        'mantiq'
                    ); ?> <span
                            class="material-icons">open_in_new</span></a>
            </summary>

            <json-editor id="comment-arguments" v-model="arguments.customArguments"></json-editor>
        </details>
    </div>
</div>
