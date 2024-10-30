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
</div>
