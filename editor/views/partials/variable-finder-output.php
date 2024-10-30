<button class="text-start bg-transparent border-0 col-12 opacity-on-hover"
        @click.stop="filteredSubOutputs.length ? toggle() : $emit('use', output)">
    <div class="d-flex align-items-center px-4">
        <small v-if="output.parent" class="text-muted opacity-50 material-icons me-3" style="font-size: 14px">subdirectory_arrow_right</small>
        <div class="me-auto">
            <code v-text="output.id"></code>
            <span class="badge text-dark bg-light rounded-pill border border-1 text-capitalize fw-normal ms-2"
                  v-text="output.type.humanName"></span>
            <br>
            <div class="small text-muted" v-text="output.description || output.name"></div>
        </div>
        <small v-if="filteredSubOutputs.length"
               v-text="expanded ? 'expand_less' : 'expand_more'"
               class="text-muted opacity-50 material-icons me-2"></small>
        <template v-else>
            <div class="py-1 px-2 bg-success-light rounded-pill" v-if="used">
                <small class="text-success me-2"><?php _e('Used', 'mantiq') ?></small>
                <span class="material-icons text-success">check</span>
            </div>
            <template v-else>
                <div class="show-on-hover py-1 px-2 bg-primary-light rounded-pill">
                    <small class="text-muted me-2"><?php _e('Use', 'mantiq') ?></small>
                    <span class="material-icons text-primary">arrow_circle_right</span>
                </div>
                <div class="show-on-hover bg-light px-2 py-1 rounded-pill ms-2 dropdown dropdown-hover" @click.stop>
                    <span class="material-icons text-primary">more_vert</span>

                    <ul class="dropdown-menu end-0">
                        <li><button type="button" class="dropdown-item small" @click="$emit('use', transformOutput('raw', output))"><?php _e('Raw', 'mantiq') ?></button></li>
                        <li><button type="button" class="dropdown-item small" @click="$emit('use', transformOutput('timestamp', output))"><?php _e('Convert to timestamp', 'mantiq') ?></button></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><button type="button" class="dropdown-item small" @click="$emit('use', transformOutput('lowercase', output))"><?php _e('Lowercase', 'mantiq') ?></button></li>
                        <li><button type="button" class="dropdown-item small" @click="$emit('use', transformOutput('uppercase', output))"><?php _e('Uppercase', 'mantiq') ?></button></li>
                        <li><button type="button" class="dropdown-item small" @click="$emit('use', transformOutput('capitalize', output))"><?php _e('Capitalize', 'mantiq') ?></button></li>
                    </ul>
                </div>
            </template>
        </template>
    </div>
</button>
<div class="row gx-0 gy-2 py-2 border-start border-5 bg-light" v-if="filteredSubOutputs.length && expanded">
    <variable-finder-output v-for="subOutput in filteredSubOutputs"
                            :output="subOutput"
                            @use="$emit('use', $event)"></variable-finder-output>
</div>
