<div class="row gx-0 gy-3">
    <details v-for="output in outputs" class="col-12">
        <summary>
            <div class="d-inline-flex align-items-center ps-1">
                {{output.name}}
                <span class="badge text-dark bg-light rounded-pill border text-capitalize fw-normal ms-2 border-1">{{output.type.humanName}}</span>
            </div>
        </summary>
        <p class="small rounded mt-2 text-muted ps-3 mb-0" v-if="output.description">{{output.description}}</p>

        <div class="bg-primary-light p-3 mt-3 rounded" v-if="output.type.properties && output.type.properties.length > 0">
            <outputs-viewer :outputs="output.type.properties"></outputs-viewer>
        </div>
    </details>
</div>
