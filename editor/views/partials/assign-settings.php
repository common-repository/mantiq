<label class="form-label mb-3"><?php _e('Variables', 'mantiq') ?></label>
<table class="table table-borderless">
    <thead>
    <tr class="bg-primary-light">
        <th class="fw-light w-50"><?php _e('Name', 'mantiq') ?></th>
        <th class="fw-light"><?php _e('Value', 'mantiq') ?></th>
        <th class="fw-light"></th>
    </tr>
    </thead>
    <tbody>
    <tr class="align-middle" v-for="(variable, variableId) in variables">
        <td class="small ps-1">
            <span v-if="variable.name">{{ variable.name }}<br></span>
            <span :class="[variable.name ? 'small text-muted' : '']">{{variableId}}</span>
        </td>
        <td class="small"><code>{{ variable.value }}</code></td>
        <td class="text-center pe-0">
            <button class="btn btn-inline text-danger ms-auto" @click="removeVariable(variableId)">
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
                       ref="nameInput"
                       placeholder="<?php esc_attr_e('Variable name...', 'mantiq') ?>"
                       v-model="form.variable.name"
                       @keypress.enter="$refs.valueInput.focus()">

                <reference-input-helper class="w-50">
                    <input type="text" class="form-control rounded-0"
                           ref="valueInput"
                           placeholder="<?php esc_attr_e('Value...', 'mantiq') ?>"
                           v-model="form.variable.value"
                           @keypress.enter="addVariable"
                           v-variable-finder-trigger>
                </reference-input-helper>

                <button class="btn btn-sm btn-primary" @click="addVariable">
                    <span class="material-icons">add</span>
                </button>
            </div>
        </td>
    </tr>
    </tfoot>
</table>
