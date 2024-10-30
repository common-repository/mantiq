<div class="row gy-3">
    <div class="col-12">
        <label for="post-id" class="form-label"><?php _e('Post ID', 'mantiq'); ?></label>

        <reference-input-helper>
            <input type="text"
                   id="post-id"
                   class="form-control form-control-sm"
                   placeholder="<?php _e('Post ID, Post slug...', 'mantiq'); ?>"
                   v-model="arguments.postId"
                   v-variable-finder-trigger>
        </reference-input-helper>
    </div>

    <div class="col-12">
        <label for="comment-author" class="form-label"><?php _e('Author name', 'mantiq'); ?></label>

        <reference-input-helper>
            <input type="text"
                   id="comment-author"
                   class="form-control form-control-sm"
                   placeholder="<?php _e('Comment author name...', 'mantiq'); ?>"
                   v-model="arguments.name"
                   v-variable-finder-trigger>
        </reference-input-helper>
    </div>

    <div class="col-12">
        <label for="comment-email" class="form-label"><?php _e('Author email', 'mantiq'); ?></label>

        <reference-input-helper>
            <input type="text"
                   id="comment-email"
                   class="form-control form-control-sm"
                   placeholder="<?php _e('Comment author email...', 'mantiq'); ?>"
                   v-model="arguments.email"
                   v-variable-finder-trigger>
        </reference-input-helper>
    </div>

    <div class="col-12">
        <label for="comment-content" class="form-label"><?php _e('Content', 'mantiq'); ?></label>

        <reference-input-helper>
                    <textarea id="comment-content"
                              class="form-control form-control-sm"
                              placeholder="<?php _e('Post content...', 'mantiq'); ?>"
                              rows="4"
                              v-model="arguments.content" v-variable-finder-trigger></textarea>
        </reference-input-helper>
    </div>

    <div class="col-12">
        <label for="comment-status" class="form-label"><?php _e('Status', 'mantiq'); ?></label>
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
    </div>

    <div class="col-12 d-flex align-items-center pt-3">
        <small class="text-uppercase text-primary"><?php _e('Advanced users zone', 'mantiq'); ?></small>
        <div class="border-bottom border-primary flex-fill ms-3"></div>
    </div>

    <div class="col-12">
        <label for="comment-type" class="form-label"><?php _e('Comment Type', 'mantiq'); ?></label>

        <input type="text"
               id="comment-type"
               class="form-control form-control-sm"
               placeholder="<?php _e('Comment type...', 'mantiq'); ?>"
               v-model="arguments.type">
    </div>

    <div class="col-12">
        <details :open="arguments.customArguments ? true : undefined">
            <summary class="d-flex align-items-center form-label">
                <span><?php _e('Extra arguments', 'mantiq'); ?></span>
                <span class="badge bg-primary rounded-pill ms-2 fw-normal">JSON</span>
                <a class="ms-auto text-decoration-none small" target="_blank"
                   href="https://developer.wordpress.org/reference/functions/wp_insert_comment/#parameters"><?php _e(
                        'Docs',
                        'mantiq'
                    ); ?> <span
                            class="material-icons">open_in_new</span></a>
            </summary>

            <json-editor id="comment-arguments" v-model="arguments.customArguments"></json-editor>
        </details>
    </div>
</div>
