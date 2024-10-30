<div class="row gy-3">
    <div class="col-12">
        <label for="term-id" class="form-label"><?php _e('Term ID', 'mantiq'); ?></label>

        <reference-input-helper :single="true">
            <input type="text"
                   id="term-id"
                   class="form-control form-control-sm"
                   placeholder="<?php _e('Term ID, Term slug...', 'mantiq'); ?>"
                   v-model="arguments.id"
                   v-variable-finder-trigger>
        </reference-input-helper>
    </div>
</div>
