<template>
    <main class="profile_page">
        <Header />

        <section class="container-fluid card-bg d-flex align-items-center">
            <div class="row">

                <div class="my-auto col-md-6 profile-data" v-if="set_change === 0">
                    <div class="profile_image rounded-circle mx-auto mb-3">
                        <img 
                            :src="getUrl + user.image" 
                            alt="Profile photo">    
                    </div>

                    <h1 class="text-dynamic text-capitalize my-auto px-5 mt-5">{{user.name}}</h1>
                    
                    <fieldset class="form-items px-5 mt-3">
                        <label for="input_status">Estado: </label>
                        <input
                            class="control regular rounded-lg text-center" 
                            type="text" 
                            ref="input_status"
                            @keyup.enter="handleStatus"
                            v-model="user.chat_status">

                        <div class="alert alert-success py-2 mt-0 rounded-lg" v-if="status_changed">
                            <p cass="my-auto">Estado actualizado correctamente.</p>
                        </div>
                    </fieldset>
                </div>

                <div class="my-auto col-md-6 mx-auto px-5 d-flex justify-content-center align-items-center">
                    <template v-if="set_change === 0">
                        <div class="d-flex flex-column">
                            <button 
                                @click="set_change = 1"
                                class="btn btn-light-primary rounded-pill px-5">
                                Modificar datos personales
                            </button>

                            <button 
                                @click="set_change = 2"
                                class="btn btn-light-primary mt-2 rounded-pill px-5">
                                Modificar contraseña
                            </button>

                            <button 
                                @click="handleLogout"
                                class="btn btn-light-dark mt-2 rounded-pill px-5">
                                Cerrar sesión
                            </button>
                        </div>
                    </template>

                    <template v-if="set_change === 1">
                        <ChangeProfileInfo 
                            :user_id="user.id"
                            :user_name="user.name"
                            :user_email="user.email" 
                            :user_image="user.image" 
                            @sucessDataChanged="updateUser($event)"
                            @back="set_change = 0" />
                    </template>

                    <template v-if="set_change === 2">
                        <ChangePassword @back="set_change = 0" />
                    </template>
                </div>

            </div>
        </section>

    </main>
</template>

<script>
import Header from '@/components/Home/Header'
import ChangeProfileInfo from '@/components/Profile/ChangeProfileInfo'
import ChangePassword from '@/components/Profile/ChangePassword'
import { mapMutations } from 'vuex'

export default {
    name: 'Profile',

    components: {
        Header,
        ChangeProfileInfo,
        ChangePassword
    },

    data() {
        return {
            user: [],
            error: [],
            status_changed: false,
            is_error: false,
            set_change: 0
        }
    },

    computed: {
        getUrl() {
            return process.env.VUE_APP_URL_STORAGE
        }
    },

    mounted() {
        this.$nextTick(() => this.getCurrentUser())
    },

    methods: {
        ...mapMutations(['destroySession', 'changeUserData']),

        async handleLogout() {
            this.axios.post('logout')
            .then(response => {
                this.destroySession()
                window.localStorage.removeItem('auth_token')
                window.localStorage.removeItem('auth_user')
                this.$router.push('/login')
                return response
            })
            .catch(error => console.log(error))
        },

        async getCurrentUser() {
            try {
                const response = await this.axios.get('user')
                this.user = response.data               
            } catch (error) {
                this.is_error = true
                this.error = error                
            }
        },

        async handleStatus() {
            this.status_changed = false

            try {
                this.$refs.input_status.blur()

                const formData = new FormData()
                formData.append('chat_status', this.user.chat_status)
                formData.append("_method", "PUT")

                const response = await this.axios.post(`users/${this.user.id}`, formData, {
                    headers: {'Content-Type': 'multipart/form-data'}                
                })

                this.status_changed = true
                this.changeUserData(response.data.data)
                setTimeout(() => this.status_changed = false, 5000);
                return response
            } catch (error) {
                console.log(error)
            }
        },     

        updateUser(user) {
            this.user.name = user.name
            this.user.image = user.image
        }
    },
}
</script>

<style lang="scss" scoped>
    .container-fluid {
        min-height: calc(100vh - 4rem);
        height: 100%;

        .profile_image {
            width: 160px;
            height: 160px;
            overflow: hidden;

            img {
                object-fit: cover;
                width: 100%;
                height: 100%;
            }
        }
    }

    @media(max-width: 768px) {
        .flex-md-reverse {
            flex-direction: column-reverse;
        }
    }

    .w-custom {
        margin: 0 auto;
        max-width: 300px;
        width: 100%;
    }
</style>