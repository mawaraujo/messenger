<template>
    <header class="py-3 w-100 text-cente d-flex flex-column align-items-center secondary-bg">
        <router-link
            title="Perfil" 
            to="/profile" 
            class="text-capitalize d-flex flex-column">

            <div class="profile-image">
                <img 
                    :src="getUrl + user_image" 
                    alt="Profile image">
            </div>
        </router-link>

        <div class="link mt-3" title="Inicio">
            <router-link to="/home">
                <font-awesome-icon class="text-dynamic" icon="home" />
            </router-link>
        </div>

        <div class="link mt-3" title="Perfil">
            <router-link to="/profile">
                <font-awesome-icon class="text-dynamic" icon="user" />
            </router-link>
        </div>

        <div class="link mt-3" title="Cerrar sesión">
            <div class="pointer" @click="handleLogout">
                <font-awesome-icon class="text-dynamic" icon="sign-out-alt" />
            </div>
        </div>
    </header>
</template>

<script>
import { mapState, mapMutations } from 'vuex'

export default {
    name: 'Header',

    data() {
        return {
            user_name: '',
            user_image: '',
        }
    },
    
    computed: {
        ...mapState(['session_store']),

        getUrl() {
            return process.env.VUE_APP_URL_STORAGE
        }
    },

    mounted() {
        this.$nextTick(() => this.getUser())
    },

    methods: {
        ...mapMutations(['destroySession']),

        getUser() {
            const user = this.session_store[0].auth_user
            this.user_name = user.name 
            this.user_image = user.image
        },
        
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
    }
}
</script>

<style lang="scss" scoped>
    header {
        height: 100vh;

        .link {
            width: 30px;
            height: 30px;
            line-height: 30px;
            text-align: center;
            border-radius: 50%;
            background: #e2e2e4;
        }

        .profile-image {
            width: 30px;
            height: 30px;
            margin: auto 0;
            border-radius: 50%;
            overflow: hidden;

            img {
                object-fit: cover;
                width: 100%;
                height: 100%;
            }
        }
    }
</style>