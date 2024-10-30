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
</div>
