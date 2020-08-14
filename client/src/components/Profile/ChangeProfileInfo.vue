<template>
    <div class="change-profile-info w-100 py-5">
        <div class="back mb-4 pointer">
            <span @click="$emit('back', true)" title="Ir hacia atrás">
                    <font-awesome-icon icon="arrow-left" />
            </span>
        </div>

        <div class="title">
            <h1 class="h3 text-dynamic">Tú perfil</h1>
        </div>

        <form class="mt-4">
            <fieldset class="form-items">
                <label class="small" for="name">Nombre completo</label>
                <input 
                class="control regular" 
                type="text" 
                id="name"
                v-model="form_fields.name">
            </fieldset>

            <fieldset class="form-items">
                <label class="small" for="email">Correo electrónico</label>
                <input 
                class="control regular" 
                type="email" 
                id="email"
                v-model="form_fields.email">
            </fieldset>

            <div class="submit text-right">
                <button 
                    @click.prevent="handleSubmit"
                    class="btn btn-primary rounded-pill px-3">
                    Actualizar datos
                </button>
            </div>
        </form>
    </div>
</template>

<script>
export default {
    name: 'ChangeProfileInfo',

    props: {
        user_name: {
            required: true,
            type: String
        },

        user_email: {
            required: true,
            type: String
        }
    },

    data() {
        return {
            form_fields: {
                name: '',
                email: ''
            }
        }
    },

    created() {
        this.form_fields.name = this.user_name
        this.form_fields.email = this.user_email
    },

    methods: {
        handleSubmit() {
            console.log(this.form_fields)
        }
    }
}
</script>

<style lang="scss" scoped>
</style>