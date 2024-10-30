<table class="table table-borderless">
    <thead>
    <tr class="bg-primary-light">
        <th class="fw-light w-50"><?php _e('Name', 'mantiq') ?></th>
        <th class="fw-light"><?php _e('Type', 'mantiq') ?></th>
        <th class="fw-light"><?php _e('Required', 'mantiq') ?></th>
        <th class="fw-light"></th>
    </tr>
    </thead>
    <tbody>
    <tr class="align-middle" v-for="(parameter, parameterId) in parameters">
        <td class="small"><span v-if="parameter.name">{{ parameter.name }}<br></span><span :class="[parameter.name ? 'small text-muted' : '']">{{parameterId}}</span></td>
        <td class="small text-capitalize"><code>{{ parameter.type.humanName }}</code></td>
        <td class="text-center">
            <input type="checkbox" class="form-check-input" v-model="parameter.required">
        </td>
        <td class="text-center">
            <button class="btn btn-inline text-danger ms-auto" @click="removeParameter(parameterId)">
                <span class="material-icons">delete</span>
            </button>
        </td>
    </tr>
    </tbody>
    <tfoot>
    <tr>
        <td class="rounded" colspan="4">
            <div class="input-group input-group-sm">
                <input type="text" class="form-control" style="flex: 2.5"
                       placeholder="Parameter name..."
                       v-model="form.parameter.name"
                       @keypress.enter="addParameter">
                <select class="form-select form-select-sm pe-4" v-model="form.parameter.type">
                    <option value="string"><?php _e('String', 'mantiq') ?></option>
                    <option value="number"><?php _e('Number', 'mantiq') ?></option>
                    <option value="boolean"><?php _e('Boolean', 'mantiq') ?></option>
                    <option value="any"><?php _e('Any', 'mantiq') ?></option>
                </select>
                <button class="btn btn-sm btn-primary" @click="addParameter">
                    <span class="material-icons">add</span>
                </button>
            </div>
            <div class="small mt-2 text-primary"><span class="badge bg-primary me-1"><?php _e('Pro tip', 'mantiq') ?></span> <?php _e('Add * to the name to make it required.', 'mantiq') ?></div>
        </td>
    </tr>
    </tfoot>
</table>
