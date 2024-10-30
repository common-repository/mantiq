<div class="row gy-3">
    <div class="col-12">
        <label for="content-body" class="form-label">Content</label>
        <reference-input-helper>
        <textarea id="content-body"
                  class="form-control form-control-sm"
                  placeholder="Content..."
                  rows="4"
                  v-model="arguments.content"
                  v-variable-finder-trigger></textarea>
        </reference-input-helper>
    </div>
    <div class="col-12">
        <label for="content-body" class="form-label">Context</label>
        <reference-input-helper :single="true">
            <input id="content-body"
                   class="form-control form-control-sm"
                   placeholder="Context..."
                   v-model="arguments.context"
                   v-variable-finder-trigger>
        </reference-input-helper>
    </div>
    <div class="col-12">
        <label for="log-level" class="form-label"><?php _e('Level', 'mantiq'); ?></label>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="log-level"
                   id="log-level-info" v-model="arguments.level"
                   checked
                   value="info">
            <label class="form-check-label" for="log-level-info">
                <?php _e('Info', 'mantiq'); ?>
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="log-level"
                   id="log-level-error" v-model="arguments.level"
                   value="error">
            <label class="form-check-label" for="log-level-error">
                <?php _e('Error', 'mantiq'); ?>
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="log-level"
                   id="log-level-warning" v-model="arguments.level"
                   value="warning">
            <label class="form-check-label" for="log-level-warning">
                <?php _e('Warning', 'mantiq'); ?>
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="log-level"
                   id="log-level-debug" v-model="arguments.level"
                   value="debug">
            <label class="form-check-label" for="log-level-debug">
                <?php _e('Debug', 'mantiq'); ?>
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="log-level"
                   id="log-level-success" v-model="arguments.level"
                   value="success">
            <label class="form-check-label" for="log-level-success">
                <?php _e('Success', 'mantiq'); ?>
            </label>
        </div>
    </div>
</div>
