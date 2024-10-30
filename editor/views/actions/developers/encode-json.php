<div class="row gy-3">
    <div class="col-12">
        <label for="content-body" class="form-label">Content</label>
        <reference-input-helper :single="true">
            <input id="content-body"
                   class="form-control form-control-sm"
                   placeholder="Content..."
                   v-model="arguments.content"
                   v-variable-finder-trigger>
        </reference-input-helper>
    </div>
    <div class="col-12">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="pretty-print"
                   id="pretty-print" v-model="arguments.pretty_print"
                   value="1">
            <label class="form-check-label" for="pretty-print">
                <?php _e('Pretty print', 'mantiq'); ?>
            </label>
        </div>
    </div>

</div>
