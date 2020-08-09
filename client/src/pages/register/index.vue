<template>
    <main class="container">

        <div class="header_container row">
            <div class="col-12">
                <Header  
                    name_to="¿Ya tienes cuenta? Inicia sesión" 
                    link_to="/login" />
            </div>
        </div>

        <div class="main row d-flex align-items-center">
            <div class="col-md-5 mx-auto card-bg p-5 rounded-lg shadow">
                <div class="branding text-center">
                    <h1 class="text-dynamic mb-4">Registro</h1>
                </div>

                <form action>

                    <fieldset class="form-items">
                        <label for="name">
                            <small>Nombre completo</small>
                        </label>

                        <input 
                            v-model="form_name"
                            type="text" 
                            id="name" 
                            class="control regular rounded">
                    </fieldset>

                    <fieldset class="form-items">
                        <label for="email">
                            <small>Correo electrónico</small>
                        </label>

                        <input 
                            v-model="form_email"
                            type="text" 
                            id="email" 
                            class="control regular rounded">
                    </fieldset>

                    <fieldset class="form-items">
                        <label for="password">
                            <small>Contraseña</small>
                        </label>

                        <input 
                            v-model="form_password"
                            type="password" 
                            id="password" 
                            class="control regular rounded">
                    </fieldset>

                    <fieldset class="form-items">
                        <label for="password_confirm">
                            <small>Confirmar contraseña</small>
                        </label>

                        <input 
                            v-model="form_c_password"
                            type="password" 
                            id="password_confirm" 
                            class="control regular rounded">
                    </fieldset>

                    <div class="button mt-4">
                        <button 
                            @click.prevent="handleRegister"
                            class="btn btn-primary rounded d-block w-100">
                            Registrarte
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </main>
</template>

<script>
import Header from '@/components/Guest/Header'

export default {
    name: 'Register',

    components: {
        Header
    },

    data() {
        return {
            form_name: "",
            form_email: "",
            form_password: "",
            form_c_password: "",
            is_error: false,
            response: []
        }
    },

    methods: {
        handleRegister() {
            this.is_error = false

            let formData = new FormData()
            formData.append('name', this.form_name);
            formData.append('email', this.form_email);
            formData.append('password', this.form_password); 
            formData.append('password_confirmation', this.form_c_password); 

            this.axios.post('register', formData)
            .then(response => {
                this.response = response.data
                return this.$router.push('/login?registered=true')
            })
            .catch(error => {
                const { data } = error.response
                this.is_error = true
                console.log(data)
            })
        }
    },  
}
</script>

<style lang="scss" scoped>
    .main {
        min-height: 100vh;
        height: 100%;
        width: 100%;
    }

</style>