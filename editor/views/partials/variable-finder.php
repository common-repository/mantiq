<div class="variable-finder-backdrop" v-if="visible" @keyup.esc="hide" @click.self="hide">
    <div class="variable-finder">
        <input type="search"
               class="form-control form-control-lg border-0 border-bottom rounded-0 p-4 m-0 shadow-sm position-relative flex-shrink-0"
               placeholder="<?php esc_attr_e('Search outputs...', 'mantiq') ?>"
               v-model="search"
               ref="searchInput">
        <div class="variable-finder-results overflow-auto custom-scrollbars flex-fill">
            <template v-if="fetching">
                <div class="text-muted p-4">Fetching...</div>
            </template>
            <template v-else v-for="node in nodes" :key="node.uid">
                <template v-if="outputs[node.uid].length">
                    <div class="d-flex align-items-center bg-light px-3 py-2">
                        <span class="material-icons me-2" v-text="node.type_icon"></span>
                        <span v-text="node.properties.name || node.type_label"></span>
                    </div>
                    <div class="row gx-0 gy-2 py-3">
                        <template v-for="output in outputs[node.uid]" :key="output.id">
                            <template v-if="!search || outputFilter(output)">
                                <variable-finder-output :output="output"
                                                        @use="useOutput(node, $event)"></variable-finder-output>
                            </template>
                        </template>
                    </div>
                    <div class="hstack px-4 pb-4 small text-muted" v-if="node.fetchingOutputs">
                        <div class="spinner-border spinner-border-sm me-2" role="status">
                        </div>
                        Loading dynamic outputs...
                    </div>
                </template>
            </template>
        </div>
    </div>
</div>
