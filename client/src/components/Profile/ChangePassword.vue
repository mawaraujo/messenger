<template>
    <div class="change-password w-100 py-5">
        <div class="back mb-4 pointer">
            <span @click="$emit('back', true)" title="Ir hacia atrás">
                    <font-awesome-icon icon="arrow-left" />
            </span>
        </div>

        <div class="title">
            <h1 class="h3 text-dynamic">Cambiar contraseña</h1>
        </div>

        <form class="mt-4">
            <fieldset class="form-items">
                <label class="small" for="password">Contraseña nueva</label>
                <input 
                class="control regular" 
                type="password" 
                id="password"
                v-model="form_fields.password">
            </fieldset>

            <fieldset class="form-items">
                <label class="small" for="c_password">Confirmar Contraseña</label>
                <input 
                class="control regular" 
                type="password" 
                id="c_password"
                v-model="form_fields.c_password">
            </fieldset>

            <div class="submit text-right">
                <button 
                    @click.prevent="handleSubmit"
                    class="btn btn-primary rounded-pill px-3">
                    Actualizar contraseña
                </button>
            </div>
        </form>
    </div>
</template>

<script>
export default {
    name: 'ChangePassword',

    data() {
        return {
            form_fields: {
                password: '',
                c_password: ''
            }
        }
    },

    methods: {
        async handleSubmit() {
            console.log(this.form_fields)
        }
    }
}
</script>

<style lang="scss" scoped>
</style>