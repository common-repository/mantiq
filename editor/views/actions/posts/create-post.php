<div class="row gy-3">
    <div class="col-12">
        <label for="post-title" class="form-label"><?php _e('Title', 'mantiq'); ?></label>

        <reference-input-helper>
            <input type="text"
                   id="post-title"
                   class="form-control form-control-sm"
                   placeholder="<?php _e('Post title...', 'mantiq'); ?>"
                   v-model="arguments.title"
                   v-variable-finder-trigger>
        </reference-input-helper>
    </div>

    <div class="col-12">
        <label for="post-content" class="form-label"><?php _e('Content', 'mantiq'); ?></label>

        <reference-input-helper>
                    <textarea id="post-content"
                              class="form-control form-control-sm"
                              placeholder="<?php _e('Post content...', 'mantiq'); ?>"
                              rows="4"
                              v-model="arguments.content" v-variable-finder-trigger></textarea>
        </reference-input-helper>
    </div>

    <div class="col-12">
        <label for="post-status" class="form-label"><?php _e('Status', 'mantiq'); ?></label>
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
    </div>

    <div class="col-12">
        <label for="post-author" class="form-label"><?php _e('Author', 'mantiq'); ?></label>

        <reference-input-helper>
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
        <label for="post-type" class="form-label"><?php _e('Post Type', 'mantiq'); ?></label>

        <input type="text"
               id="post-type"
               class="form-control form-control-sm"
               placeholder="<?php _e('Post type...', 'mantiq'); ?>"
               v-model="arguments.type"
               list="post-types-list">
        <datalist id="post-types-list">
            <?php foreach (get_post_types(['public' => true, 'show_ui' => true], 'objects') as $postType): ?>
                <option value="<?php echo $postType->name; ?>"><?php echo $postType->labels->singular_name; ?></option>
            <?php endforeach; ?>
        </datalist>
    </div>

    <div class="col-12">
        <details :open="arguments.customArguments ? true : undefined">
            <summary class="d-flex align-items-center form-label">
                <span><?php _e('Extra arguments', 'mantiq'); ?></span>
                <span class="badge bg-primary rounded-pill ms-2 fw-normal">JSON</span>
                <a class="ms-auto text-decoration-none small" target="_blank"
                   href="https://developer.wordpress.org/reference/functions/wp_insert_post/#parameters"><?php _e('Docs', 'mantiq'); ?> <span
                            class="material-icons">open_in_new</span></a>
            </summary>

            <json-editor id="post-arguments" v-model="arguments.customArguments"></json-editor>
        </details>
    </div>
</div>
