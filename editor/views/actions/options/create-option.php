<div class="row gy-3">
    <div class="col-12" :options="argument('options', [])">
        <repeatable :model="{key: '', value: ''}" v-model="arguments.options" v-slot="{items, add, remove, form}"
                    @add="$refs.keyInput.focus()">
            <table class="table table-borderless">
                <thead>
                <tr class="bg-primary-light">
                    <th class="fw-light w-50">Key</th>
                    <th class="fw-light">Value</th>
                    <th class="fw-light"></th>
                </tr>
                </thead>
                <tbody>
                <tr class="align-middle" v-for="(item, itemId) in items">
                    <td class="small ps-1" v-text="item.key"></td>
                    <td class="small"><code v-text="item.value"></code></td>
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
                                       placeholder="Value..."
                                       v-model="form.value"
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
