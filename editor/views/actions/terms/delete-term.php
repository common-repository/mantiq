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

</div>
