<div class="position-fixed bottom-0 start-0 p-3" style="z-index: 999999">
    <transition-group name="slide-fade" tag="div">
        <div class="toast mt-3 show border-0" v-for="(notification, index) in notifications" :key="index">
            <div class="toast-header text-white" :class="['bg-' + notification.color]">
                <span class="material-icons me-2" v-text="notification.icon"></span>
                <span class="me-auto" v-text="notification.title"></span>
            </div>
            <div class="toast-body" v-text="notification.body"></div>
        </div>
    </transition-group>
</div>
