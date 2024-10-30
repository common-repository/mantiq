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
</div>
