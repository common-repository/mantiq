<div class="modal-backdrop fade show"></div>
<div class="modal fade show d-block"
     @click.self="close"
     @keyup.esc="close"
     @dragover.prevent="dragEnter"
     @dragleave.prevent="dragLeave"
     @drop.prevent.stop="drop($event)">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="position-absolute start-0 end-0 top-0 bottom-0 bg-white bg-opacity-75 p-3 zi-1 pe-none"
                 v-if="dragAndDrop">
                <div class="border-5 border-primary fs-3 border-dashed d-flex align-items-center justify-content-center h-100">
                    <?php _e('Drop the workflow file here', 'mantiq') ?>
                </div>
            </div>
            <div class="modal-header border-0 px-4 bg-primary-light">
                <h5 class="modal-title"><?php _e('Import Workflow', 'mantiq') ?></h5>
                <button @click="close" type="button" class="btn-close"></button>
            </div>
            <div class="modal-body">
                <json-editor v-model="workflow"
                             placeholder="<?php esc_attr_e("Paste or drop workflow's file...", 'mantiq') ?>"
                             :autofocus="true"
                             ref="editor"></json-editor>
            </div>
            <div class="modal-footer border-0">
                <button @click="close" type="button" class="btn btn-outline-secondary"><?php _e('Close', 'mantiq') ?></button>
                <button @click="process" type="button" class="btn btn-primary"><?php _e('Import', 'mantiq') ?></button>
            </div>
        </div>
    </div>
</div>
