<template v-if="compact">
    <button class="btn btn-sm btn-inline">
        <span class="material-icons">more_vert</span>
    </button>
</template>
<template v-else>
    <button class="btn btn-dark w-100" @click="connect" :disabled="isLoading">
        <template v-if="isLoading">
            <?php _e('Connecting', 'mantiq') ?>
        </template>
        <template v-else>
            <span class="material-icons me-1">add</span>
            <?php _e('Add new connection', 'mantiq') ?>
        </template>
    </button>
    <div class="d-flex align-items-center justify-content-center text-primary small py-2">
        <span class="material-icons me-1">verified_user</span>
        <?php _e('Connections are securely stored on your website.', 'mantiq') ?>
    </div>
</template>
