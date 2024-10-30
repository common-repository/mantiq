<div class="row gy-3">
    <div class="col-12">
        <label for="object-id" class="form-label"><?php _e('Object ID', 'mantiq'); ?></label>

        <reference-input-helper :single="true">
            <input type="text"
                   id="object-id"
                   class="form-control form-control-sm"
                   placeholder="<?php _e('Post ID, Post slug...', 'mantiq'); ?>"
                   v-model="arguments.id"
                   v-variable-finder-trigger>
        </reference-input-helper>
    </div>

    <div class="col-12">
        <label for="object-type" class="form-label"><?php _e('Object Type', 'mantiq'); ?></label>
        <?php
        $objectTypes = [
            'post'    => __('Post', 'mantiq'),
            'comment' => __('Comment', 'mantiq'),
            'term'    => __('Term', 'mantiq'),
            'user'    => __('User', 'mantiq'),
        ];
        ?>
        <?php foreach ($objectTypes as $objectTypeId => $objectTypeLabel): ?>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="object-type"
                       id="object-type-<?php echo esc_attr($objectTypeId); ?>" v-model="arguments.type"
                       value="<?php echo esc_attr($objectTypeId); ?>">
                <label class="form-check-label" for="object-type-<?php echo esc_attr($objectTypeId); ?>">
                    <?php echo esc_html($objectTypeLabel); ?>
                </label>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="col-12" :entries="argument('entries', [])">
        <repeatable :model="{key: '', fallback: ''}" v-model="arguments.entries" v-slot="{items, add, remove, form}"
                    @add="$refs.keyInput.focus()">
            <table class="table table-borderless">
                <thead>
                <tr class="bg-primary-light">
                    <th class="fw-light w-50">Key</th>
                    <th class="fw-light">Fallback value</th>
                    <th class="fw-light"></th>
                </tr>
                </thead>
                <tbody>
                <tr class="align-middle" v-for="(item, itemId) in items">
                    <td class="small ps-1" v-text="item.key"></td>
                    <td class="small"><code v-text="item.fallback"></code></td>
                    <td class="text-center pe-0">
                        <button class="btn btn-inline text-danger ms-auto" @click="remove(item)">
                            <span class="material-icons">delete</span>
                        </button>
                    </td>
                </tr>
                </tbody>
                <tfoot>
                <tr>
                    <td class="rounded px-0" colspan="4">
                        <div class="input-group input-group-sm">
                            <input type="text" class="form-control"
                                   ref="keyInput"
                                   placeholder="Key..."
                                   v-model="form.key"
                                   @keypress.enter="$refs.valueInput.focus()">

                            <reference-input-helper class="w-50">
                                <input type="text" class="form-control rounded-0"
                                       ref="valueInput"
                                       placeholder="Fallback value..."
                                       v-model="form.fallback"
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
</div>
