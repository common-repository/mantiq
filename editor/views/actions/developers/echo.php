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
</div>
