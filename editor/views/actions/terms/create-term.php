<div class="row gy-3">
    <div class="col-12">
        <label for="term-name" class="form-label"><?php _e('Name', 'mantiq'); ?></label>

        <reference-input-helper>
            <input type="text"
                   id="term-name"
                   class="form-control form-control-sm"
                   placeholder="<?php _e('Term name...', 'mantiq'); ?>"
                   v-model="arguments.name"
                   v-variable-finder-trigger>
        </reference-input-helper>
    </div>

    <div class="col-12">
        <label for="term-description" class="form-label"><?php _e('Description', 'mantiq'); ?></label>

        <reference-input-helper>
            <input type="text"
                   id="term-description"
                   class="form-control form-control-sm"
                   placeholder="<?php _e('Term description...', 'mantiq'); ?>"
                   v-model="arguments.description"
                   v-variable-finder-trigger>
        </reference-input-helper>
    </div>

    <div class="col-12">
        <label for="term-taxonomy" class="form-label"><?php _e('Taxonomy', 'mantiq'); ?></label>

        <input type="text"
               id="term-taxonomy"
               class="form-control form-control-sm"
               placeholder="<?php _e('Term taxonomy...', 'mantiq'); ?>"
               v-model="arguments.taxonomy"
               list="term-taxonomies-list">
        <datalist id="term-taxonomies-list">
            <?php foreach (get_taxonomies(['public' => true, 'show_ui' => true], 'objects') as $taxonomy): ?>
                <option value="<?php echo $taxonomy->name; ?>"><?php echo $taxonomy->labels->singular_name; ?></option>
            <?php endforeach; ?>
        </datalist>
    </div>

    <div class="col-12">
        <label for="term-parent" class="form-label"><?php _e('Parent', 'mantiq'); ?></label>

        <reference-input-helper>
            <input type="text"
                   id="term-parent"
                   class="form-control form-control-sm"
                   placeholder="<?php _e('Term ID, Term slug...', 'mantiq'); ?>"
                   v-model="arguments.parent"
                   v-variable-finder-trigger>
        </reference-input-helper>
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
                   href="https://developer.wordpress.org/reference/functions/wp_insert_term/#parameters"><?php _e('Docs', 'mantiq'); ?> <span
                            class="material-icons">open_in_new</span></a>
            </summary>

            <json-editor id="term-arguments" v-model="arguments.customArguments"></json-editor>
        </details>
    </div>
</div>
