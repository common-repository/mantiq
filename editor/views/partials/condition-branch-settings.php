<template v-if="properties.isDefault">
    <?php _e('Default branch cannot have conditions.', 'mantiq') ?>
</template>
<template v-else>
    <div class="mb-3">
        <label for="branch-name" class="form-label">Name</label>
        <input class="form-control form-control-sm" type="text" name="branch-name" id="branch-name"
               v-model="properties.name"/>
    </div>

    <div class="mb-3">
        <label for="branch-name" class="form-label d-block">Conditions</label>
        <div class="border rounded mb-3"
             v-for="(condition, conditionIndex) in properties.conditions">
            <div class="d-flex align-items-center p-2 border-bottom bg-light">
                <small class="me-2"><?php _e('Condition', 'mantiq') ?> #{{ conditionIndex + 1 }}</small>
                <button @click="removeCondition(condition)"
                        class="btn btn-sm btn-inline text-danger ms-auto"><span class="material-icons">delete</span>
                </button>
            </div>

            <div class="p-3">
                <div class="row gy-3 align-items-center mb-2">
                    <span class="col-3 text-muted"><?php _e('Source', 'mantiq') ?></span>
                    <div class="col-9">
                        <reference-input-helper :single="true">
                            <input type="text"
                                   class="form-control form-control-sm text-truncate"
                                   placeholder="<?php esc_attr_e('Source', 'mantiq') ?>"
                                   v-model="condition.source"
                                   v-variable-finder-trigger>
                        </reference-input-helper>
                    </div>

                    <span class="col-3 text-muted"><?php _e('Operator', 'mantiq') ?></span>
                    <div class="col-9">
                        <select v-model="condition.operator" class="form-control form-control-sm text-truncate">
                            <option value="" selected><?php _e('Operator', 'mantiq') ?></option>
                            <option v-for="(operator, operatorIndex) in operators"
                                    :key="operatorIndex"
                                    :value="operator.value">{{ operator.label }}
                            </option>
                        </select>
                    </div>

                    <template v-if="!operators[condition.operator]?.isUnary">
                        <span class="col-3 text-muted"><?php _e('Value', 'mantiq') ?></span>
                        <div class="col-9">
                            <reference-input-helper :single="true">
                                <input v-model="condition.value"
                                       type="text"
                                       class="form-control form-control-sm text-truncate"
                                       placeholder="<?php esc_attr_e('Value...', 'mantiq') ?>"
                                       v-variable-finder-trigger/>
                            </reference-input-helper>
                        </div>
                    </template>
                </div>
            </div>
        </div>

        <button class="btn btn-sm link-primary text-decoration-none btn-inline" @click="addCondition">
            <span class="material-icons me-2">add</span>
            <?php _e('New condition', 'mantiq') ?>
        </button>
    </div>


    <div class="mb-3">
        <label for="branch-evaluation-order" class="form-label"><?php _e('Evaluation order', 'mantiq') ?></label>
        <input type="text" class="form-control form-select-sm" id="branch-evaluation-order"
               placeholder="<?php esc_attr_e('Example: (1 AND 2) OR 3', 'mantiq') ?>" v-model="properties.evaluationOrder"/>
    </div>
</template>
