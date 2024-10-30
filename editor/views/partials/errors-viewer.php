<div class="alert alert-danger p-2" v-for="errorsGroup in errors.items">
    <div v-for="error in errorsGroup">{{ error.message }}</div>
</div>
