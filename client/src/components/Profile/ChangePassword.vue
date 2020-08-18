<template>
    <div class="change-password w-100 py-5">
        <div class="back mb-4 pointer h4 d-flex" @click="$emit('back', true)" title="Ir hacia atrás">
            <span class="my-auto mr-3">
                    <font-awesome-icon icon="arrow-left" />
            </span>

            <p class="h5 my-auto">Volver</p>
        </div>

        <form class="mt-5">
            <div class="alert alert-success my-auto py-3 mb-4 rounded-lg" v-if="success">
                <p class="my-auto h6">Contraseña actualizada con éxito.</p>
            </div>

            <div class="alert alert-danger my-auto py-3 mb-4 rounded-lg" v-if="error">
                <p class="my-auto h6">Ha ocurrido un error al procesar la acción requerida.</p>
            </div>

            <fieldset class="form-items">
                <label class="small" for="password">Contraseña nueva</label>
                <input
                v-bind:class="error_password ? 'danger' : 'regular'" 
                class="control" 
                type="password" 
                id="password"
                v-model="form_fields.password">
            </fieldset>

            <fieldset class="form-items">
                <label class="small" for="c_password">Confirmar Contraseña</label>
                <input
                v-bind:class="error_password ? 'danger' : 'regular'" 
                class="control" 
                type="password" 
                id="c_password"
                v-model="form_fields.c_password">

                <small class="text-danger mt-2" v-if="error_password">Las contraseñas no coinciden</small>
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
import { mapGetters } from 'vuex'

export default {
    name: 'ChangePassword',

    data() {
        return {
            success: false,
            error: false,
            error_password: false,

            form_fields: {
                password: '',
                c_password: ''
            }
        }
    },

    computed: {
        ...mapGetters(['getUser'])
    },

    methods: {
        async handleSubmit() {
            this.success = false
            this.error = false
            this.error_password = false

            if(this.form_fields.password !== this.form_fields.c_password) {
                return this.error_password = true
            }

            try {
                const formData = new FormData()
                formData.append('password', this.form_fields.password)
                formData.append('password_confirmation', this.form_fields.c_password)
                formData.append("_method", "PUT")

                const response = await this.axios.post(`users/${this.getUser.id}`, formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }                
                })

                this.success = true
                this.form_fields.password = ''
                this.form_fields.c_password = ''
                return response
            } catch (error) {

                this.error = true
                console.log(error)
            }
        },
    }
}
</script>

<style lang="scss" scoped>
</style>