<header class="d-flex p-3 border-bottom align-items-center">
    <span class="material-icons text-primary me-2">receipt_long</span>
    <span class="">Log <span class="text-muted" v-if="isRefreshing"><?php _e('Refreshing...', 'mantiq') ?></span></span>
    <button class="btn btn-sm btn-inline ms-auto" @click="toggleAutoRefresh" title="<?php esc_attr_e('Auto Refresh', 'mantiq') ?>">
        <span class="material-icons text-primary" v-if="autoRefresh">sync</span>
        <span class="material-icons text-secondary" v-else>sync_disabled</span>
    </button>
    <router-link v-if="!node" :to="{name: 'editor', params: {uid: workflow.uid}}" class="btn btn-sm btn-inline ms-2">
        <span class="material-icons">close</span>
    </router-link>
</header>
<section class="flex-fill overflow-auto">
    <div class="d-flex flex-column justify-content-center align-items-center py-4" v-if="isLoading">
        <div class="spinner-border mb-3" role="status">
            <span class="visually-hidden"><?php _e('Loading...', 'mantiq') ?></span>
        </div>

        <span><?php _e('Fetching logs...', 'mantiq') ?></span>
    </div>
    <pre class="p-3 h-100 m-0 text-wrap" v-else><div v-for="logEntry in log" class="p-1 d-flex align-items-start" :class="levelBackgroundColors[logEntry.level]" :title="logEntry.logged_at"><span
                    class="text-uppercase me-2 rounded-pill flex-shrink-0 text-center small" style="width: 50px;" :class="levelTextColors[logEntry.level]">{{logEntry.level}}</span>{{logEntry.message}}<br></div></pre>
</section>
