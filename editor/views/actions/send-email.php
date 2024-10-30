<div class="row gy-3">
    <div class="col-12">
        <label for="send-email-to" class="form-label"><?php _e('To', 'mantiq'); ?></label>

        <reference-input-helper>
            <input type="email"
                   id="send-email-to"
                   class="form-control form-control-sm"
                   placeholder="<?php esc_attr_e('Email to...', 'mantiq'); ?>"
                   v-model="arguments.to"
                   v-variable-finder-trigger>
        </reference-input-helper>
    </div>
    <div class="col-12">
        <label for="send-email-subject" class="form-label"><?php _e('Subject', 'mantiq'); ?></label>

        <reference-input-helper>
            <input type="text"
                   id="send-email-subject"
                   class="form-control form-control-sm"
                   placeholder="<?php esc_attr_e('Email subject...', 'mantiq'); ?>"
                   v-model="arguments.subject"
                   v-variable-finder-trigger>
        </reference-input-helper>
    </div>
    <div class="col-12">
        <label for="send-email-body" class="form-label"><?php _e('Body', 'mantiq'); ?></label>
        <reference-input-helper>
        <textarea id="send-email-body"
                  class="form-control form-control-sm"
                  placeholder="<?php esc_attr_e('Email body...', 'mantiq'); ?>"
                  rows="4"
                  v-model="arguments.body"
                  v-variable-finder-trigger></textarea>
        </reference-input-helper>
    </div>

    <div class="col-12 d-flex align-items-center pt-3">
        <small class="text-uppercase text-primary"><?php _e('Advanced users zone', 'mantiq'); ?></small>
        <div class="border-bottom border-primary flex-fill ms-3"></div>
    </div>

    <div class="col-12">
        <label for="send-email-from" class="form-label"><?php _e('From', 'mantiq'); ?></label>

        <reference-input-helper>
            <input type="email"
                   id="send-email-from"
                   class="form-control form-control-sm"
                   placeholder="<?php esc_attr_e('Name <email>', 'mantiq'); ?>"
                   v-model="arguments.from"
                   v-variable-finder-trigger>
        </reference-input-helper>
    </div>

    <div class="col-12">
        <label for="send-email-replyTo" class="form-label"><?php _e('Reply To', 'mantiq'); ?></label>

        <reference-input-helper>
            <input type="email"
                   id="send-email-replyTo"
                   class="form-control form-control-sm"
                   placeholder="<?php esc_attr_e('Name <email>', 'mantiq'); ?>"
                   v-model="arguments.replyTo"
                   v-variable-finder-trigger>
        </reference-input-helper>
    </div>

    <div class="col-12">
        <label for="send-email-cc" class="form-label"><?php _e('Cc', 'mantiq'); ?></label>

        <reference-input-helper>
            <input type="email"
                   id="send-email-cc"
                   class="form-control form-control-sm"
                   placeholder="<?php esc_attr_e('Name <email>', 'mantiq'); ?>"
                   v-model="arguments.cc"
                   v-variable-finder-trigger>
        </reference-input-helper>
    </div>

    <div class="col-12">
        <label for="send-email-bcc" class="form-label"><?php _e('Bcc', 'mantiq'); ?></label>

        <reference-input-helper>
            <input type="email"
                   id="send-email-bcc"
                   class="form-control form-control-sm"
                   placeholder="<?php esc_attr_e('Name <email>', 'mantiq'); ?>"
                   v-model="arguments.bcc"
                   v-variable-finder-trigger>
        </reference-input-helper>
    </div>

    <div class="col-12" :headers="argument('headers', [])">
        <label class="form-label"><?php _e('Headers', 'mantiq'); ?></label>

        <repeatable :model="{name: '', content: ''}" v-model="arguments.headers" v-slot="{items, add, remove, form}"
                    @add="$refs.nameInput.focus()">
            <table class="table table-borderless">
                <thead>
                <tr class="bg-primary-light">
                    <th class="fw-light w-50">Name</th>
                    <th class="fw-light">Content</th>
                    <th class="fw-light"></th>
                </tr>
                </thead>
                <tbody>
                <tr class="align-middle" v-for="(item, itemId) in items">
                    <td class="small ps-1" v-text="item.name"></td>
                    <td class="small"><code v-text="item.content"></code></td>
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
                                   ref="nameInput"
                                   placeholder="<?php esc_attr_e('Name', 'mantiq'); ?>"
                                   v-model="form.name"
                                   @keypress.enter="$refs.valueInput.focus()">

                            <reference-input-helper class="w-50">
                                <input type="text" class="form-control rounded-0"
                                       ref="valueInput"
                                       placeholder="<?php esc_attr_e('Content', 'mantiq'); ?>"
                                       v-model="form.content"
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
