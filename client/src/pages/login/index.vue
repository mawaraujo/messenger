<template>
    <main class="container">

        <div class="header_container row">
            <div class="col-12">
                <Header
                    name_to="¿No tienes cuenta? Registrate" 
                    link_to="/register" />
            </div>
        </div>

        <div class="main row d-flex align-items-center">
            <div class="col-md-5 mx-auto card-bg p-5 rounded-lg shadow">
                <div class="branding text-center">
                    <h1 class="text-dynamic mb-4">Iniciar sesión</h1>
                </div>

                <!-- Error -->
                <template class="alert_error" v-if="is_error">
                    <div class="alert alert-danger py-2 rounded-lg text-center">
                        <p class="my-auto small">Email o contraseña incorrectos</p>
                    </div>
                </template>

                <!-- Success Register -->
                <template class="alert_success" v-if="isRegistered">
                    <div class="alert alert-success py-2 rounded-lg text-center">
                        <p class="my-auto small">Registro creado con éxito. Inicie sesión para continuar</p>
                    </div>
                </template>

                <form action>

                    <fieldset class="form-items">
                        <label for="email">
                            <small>Correo electrónico</small>
                        </label>

                        <input 
                            v-model="form_email"
                            v-bind:class="(form_error.input === 'email' || form_error.input === 'all') ? 'danger' : 'regular'"
                            type="text" 
                            id="email" 
                            class="control rounded">

                        <template v-if="form_error.input === 'email' || form_error.input === 'all'">
                            <small class="text-danger small">
                                {{ form_error.message }}
                            </small>
                        </template>
                    </fieldset>

                    <fieldset class="form-items">
                        <label for="password">
                            <small>Contraseña</small>
                        </label>

                        <input 
                            v-model="form_password"
                            v-bind:class="(form_error.input === 'password' || form_error.input === 'all') ? 'danger' : 'regular'"
                            type="password" 
                            id="password" 
                            class="control rounded">

                        <template v-if="form_error.input === 'password' || form_error.input === 'all'">
                            <small class="text-danger small">
                                {{ form_error.message }}
                            </small>
                        </template>
                    </fieldset>

                    <div class="button mt-4 d-flex justify-content-end">
                        <button 
                            @click.prevent="handleLogin"
                            class="btn btn-primary rounded d-flex justify-content-between">
                            
                            <template v-if="is_loading">
                                <p class="my-auto">Iniciando sesión</p>
                                <span class="spinner_load my-auto ml-3"></span>
                            </template>

                            <template v-else>
                                <p class="my-auto">Iniciar sesión</p>
                            </template>
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </main>
</template>

<script>
import Header from '@/components/Guest/Header'
import { mapState, mapMutations } from 'vuex'

export default {
    name: 'Login',

    components: {
        Header
    },

    data() {
        return {
            form_email: "",
            form_password: "",
            is_error: false,
            is_loading: false,
            form_error: {
                input: '',
                message: 'El campo no debe estár vacío'
            }
        }
    },

    computed: {
        ...mapState(['session_store']),

        isRegistered() {
            if(window.location.search.length) {
                if(window.location.search.split('?')[1].includes('registered') & !this.is_error) return true
                else return false
            } else return false
        }
    },

    mounted() {},

    methods: {
        ...mapMutations(['createSession']),

        handleInputs() {
            this.form_error.input = ''
            if(!this.form_email.length && !this.form_password.length) return this.form_error.input = 'all'

            if(!this.form_email.length) return this.form_error.input = 'email'
            else if(!this.form_password.length) return this.form_error.input = 'password'
        },

        handleLogin() {
            this.is_error = false
            this.is_loading = true

            this.handleInputs()

            // Si hay error
            if(this.form_error.input.length) {
                this.is_loading = false
                return 
            }
            
            let formData = new FormData()
            formData.append('email', this.form_email);
            formData.append('password', this.form_password);  

            this.axios.post('http://localhost:8000/api/login', formData)
            .then(response => {
                const data = response.data
                const { auth_token, user } = data

                if(auth_token && user) {
                    window.localStorage.auth_token = auth_token
                    window.localStorage.auth_user = JSON.stringify(user)
                    this.createSession({ data })
                    
                    return window.location.replace('/home')
                } else {
                    return this.is_error = true
                }
            })
            .catch(error => {
                const { data } = error.response
                this.is_error = true
                this.is_loading = false
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

    .spinner_load {
        width: 20px;
        height: 20px;
        border: 2px solid white;
        border-bottom: 2px solid transparent;
        border-radius: 50%;
        animation: spinner 0.5s linear infinite;
    }

    @keyframes spinner {
        100% {
            transform: rotate(360deg);
        }
    }
</style>