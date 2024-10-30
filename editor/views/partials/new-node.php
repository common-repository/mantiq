<div class="org-tree-leaf-separator"></div>

<div v-if="node.type !== 'condition'" :class="[{expanded: expanded}, 'node-' + node.type]" class="org-tree-leaf-btn">
    <button class="btn btn-inline btn-outline-primary fs-6 rounded-circle" style="width: 31px; height: 31px;border-style: dashed" @click.stop="toggle" v-if="!expanded">
        <span class="material-icons">add</span>
    </button>
    <div class="d-flex" v-else>
        <button class="btn-dark btn btn-sm btn-icon rounded-pill pe-3 mx-1"
                @click.stop="add('condition')">
            <span class="material-icons">rule</span>
            <?php _e('Condition', 'mantiq') ?>
        </button>
        <button class="btn-warning btn btn-sm btn-icon rounded-pill pe-3 mx-1"
                @click.stop="add('assign')">
            <span class="material-icons">exit_to_app</span>
            <?php _e('Assignment', 'mantiq') ?>
        </button>
        <button class="btn-success btn btn-sm btn-icon rounded-pill pe-3 mx-1"
                @click.stop="add('action')">
            <span class="material-icons">play_circle_filled</span>
            <?php _e('Action', 'mantiq') ?>
        </button>
    </div>
</div>
