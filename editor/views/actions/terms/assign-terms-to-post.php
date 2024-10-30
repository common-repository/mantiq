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

    <div class="col-12" :terms="argument('terms', [])">
        <repeatable :model="{id: ''}" v-model="arguments.terms" v-slot="{items, add, remove, form}">
            <table class="table table-borderless m-0">
                <thead>
                <tr class="bg-primary-light">
                    <th class="fw-light ">Term ID/Slug</th>
                    <th class="fw-light"></th>
                </tr>
                </thead>
                <tbody>
                <tr class="align-middle" v-for="(item, itemId) in items">
                    <td class="small ps-1" v-text="item.id"></td>
                    <td class="text-center pe-0">
                        <button class="btn btn-inline text-danger ms-auto" @click="remove(item)">
                            <span class="material-icons">delete</span>
                        </button>
                    </td>
                </tr>
                </tbody>
                <tfoot>
                <tr>
                    <td class="rounded px-0" colspan="2">
                        <div class="input-group input-group-sm">
                            <reference-input-helper class="flex-fill">
                                <input type="text" class="form-control rounded-0"
                                       ref="valueInput"
                                       placeholder="Term ID, Term slug..."
                                       v-model="form.id"
                                       @keypress.enter="add"
                                       v-variable-finder-trigger>
                            </reference-input-helper>

                            <button class="btn btn-sm btn-primary" @click="add">
                                <span class="material-icons">add</span>
                            </button>
                        </div>
                    </td>
                </tr>
                </tfoot>
            </table>
        </repeatable>
    </div>

    <div class="col-12">
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" role="switch" id="replace"
                   v-model="arguments.replace">
            <label class="form-check-label form-label" for="replace">
                <?php _e('Replace existing terms', 'mantiq'); ?>
            </label>
        </div>
    </div>
</div>
