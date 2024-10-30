<div class="row gy-3">
    <div class="col-12">
        <label for="request-url" class="form-label"><?php _e('URL', 'mantiq'); ?></label>
        <reference-input-helper :single="true">
            <input id="request-url"
                   class="form-control form-control-sm"
                   placeholder="URL..."
                   v-model="arguments.url"
                   v-variable-finder-trigger>
        </reference-input-helper>
    </div>

    <div class="col-12" :method="argument('method', 'get')">
        <label for="request-method" class="form-label"><?php _e('Method', 'mantiq'); ?></label>
        <select name="" id="request-method" class="form-select form-select-sm" v-model="arguments.method">
            <option value="get">GET</option>
            <option value="post">POST</option>
            <option value="put">PUT</option>
            <option value="patch">PATCH</option>
            <option value="delete">DELETE</option>
        </select>
    </div>

    <div class="col-12"
         :query="argument('query', [])"
         :headers="argument('headers', [])"
         :payload_type="argument('payload_type', 'form')"
         :payload_form="argument('payload_form', [])"
         :payload_json="argument('payload_json', '')"
         :payload_raw="argument('payload_raw', '')">
        <details v-if="arguments.method === 'post' || arguments.method === 'put' || arguments.method === 'patch'"
                 :open="(arguments.payload_form.length || arguments.payload_json.length  || arguments.payload_raw.length) ? true : undefined">
            <summary class="d-flex align-items-center form-label">
                <?php _e('Payload', 'mantiq'); ?>
            </summary>

            <div class="d-flex align-items-center py-2 px-3 bg-primary-light rounded mb-2">
                <span class="text-muted"><?php _e('Type', 'mantiq'); ?></span>

                <div class="form-check form-check-inline mt-1 mb-0 ms-auto">
                    <input class="form-check-input" type="radio" name="message-type" id="formdata-body"
                           value="form"
                           v-model="arguments.payload_type">
                    <label class="form-check-label" for="formdata-body">
                        <?php _e('Form', 'mantiq'); ?>
                    </label>
                </div>

                <div class="form-check form-check-inline mt-1 mb-0">
                    <input class="form-check-input" type="radio" name="message-type" id="json-body"
                           value="json"
                           v-model="arguments.payload_type">
                    <label class="form-check-label" for="json-body">
                        <?php _e('JSON', 'mantiq'); ?>
                    </label>
                </div>

                <div class="form-check form-check-inline mt-1 mb-0 me-0">
                    <input class="form-check-input" type="radio" name="message-type" id="raw-body"
                           value="raw"
                           v-model="arguments.payload_type">
                    <label class="form-check-label" for="raw-body">
                        <?php _e('Raw', 'mantiq'); ?>
                    </label>
                </div>
            </div>

            <repeatable v-if="arguments.payload_type === 'form'"
                        :model="{key: '', value: ''}"
                        v-model="arguments.payload_form" v-slot="{items, add, remove, form}"
                        @add="$refs.keyInput.focus()">
                <table class="table table-borderless">
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

            <json-editor v-if="arguments.payload_type === 'json'"
                         v-model="arguments.payload_json"
                         class="mb-2"></json-editor>

            <textarea v-if="arguments.payload_type === 'raw'"
                      v-model="arguments.payload_raw"
                      class="form-control form-control-sm mb-2"
                      rows="6"></textarea>
        </details>

        <details :open="arguments.query.length ? true : undefined">
            <summary class="d-flex align-items-center form-label">
                <?php _e('Query parameters', 'mantiq'); ?>
            </summary>
            <repeatable :model="{key: '', value: ''}" v-model="arguments.query"
                        v-slot="{items, add, remove, form}"
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
        </details>

        <details :open="arguments.headers.length ? true : undefined">
            <summary class="d-flex align-items-center form-label">
                <?php _e('Headers', 'mantiq'); ?>
            </summary>
            <repeatable :model="{key: '', value: ''}" v-model="arguments.headers" v-slot="{items, add, remove, form}"
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

        </details>
    </div>

    <div class="col-12 d-flex align-items-center pt-3">
        <small class="text-uppercase text-primary"><?php _e('Advanced users zone', 'mantiq'); ?></small>
        <div class="border-bottom border-primary flex-fill ms-3"></div>
    </div>

    <div class="col-12">
        <div class="form-check form-switch" :json="argument('json', true)">
            <input class="form-check-input" type="checkbox" role="switch" id="json"
                   v-model="arguments.json">
            <label class="form-check-label form-label" for="json">
                <?php _e('Decode JSON response', 'mantiq'); ?>
            </label>
        </div>

        <div class="form-check form-switch" :blocking="argument('blocking', true)">
            <input class="form-check-input" type="checkbox" role="switch" id="non-blocking"
                   v-model="arguments.blocking">
            <label class="form-check-label form-label" for="non-blocking">
                <?php _e('Block execution until receiving a response', 'mantiq'); ?><br>
                <small class="text-danger" v-if="!arguments.blocking"><?php _e('Outputs will not be available while this is disabled.', 'mantiq'); ?></small>
            </label>
        </div>

        <div class="form-check form-switch" :sslverify="argument('sslverify', true)">
            <input class="form-check-input" type="checkbox" role="switch" id="ssl-verify"
                   v-model="arguments.sslverify">
            <label class="form-check-label form-label" for="ssl-verify">
                <?php _e('Verify SSL certificate', 'mantiq'); ?>
            </label>
        </div>
    </div>

    <div class="col-12">
        <details :open="arguments.customArguments ? true : undefined">
            <summary class="d-flex align-items-center form-label">
                <span><?php _e('Extra arguments', 'mantiq'); ?></span>
                <span class="badge bg-primary rounded-pill ms-2 fw-normal">JSON</span>
                <a class="ms-auto text-decoration-none small" target="_blank"
                   rel="noopener"
                   href="https://developer.wordpress.org/reference/classes/WP_Http/request/">
                    <?php _e('Docs', 'mantiq'); ?>
                    <span class="material-icons">open_in_new</span></a>
            </summary>

            <json-editor id="post-arguments" v-model="arguments.customArguments"></json-editor>
        </details>
    </div>
</div>
