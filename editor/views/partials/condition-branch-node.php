<div class="text-center">
    <div class="bg-dark rounded-pill p-2 pe-3 d-inline-flex align-items-center text-white">
        <span class="material-icons me-2">alt_route</span>
        <small v-if="node.properties.isDefault">Default branch</small>
        <small v-else>{{ node.properties.name || 'Branch #' + (index + 1) }}</small>
    </div>
</div>
