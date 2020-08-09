<template>
    <header class="px-3 d-flex justify-content-between card-bg border-bottom">
        <div class="branding">
            <router-link to="/home" class="text-capitalize">
                {{ user_name.length ? user_name : 'Messenger' }}
            </router-link>
        </div>

        <nav class="navigation">
            <a 
                class="pointer" 
                @click="handleLogout">
                Cerrar sesión
            </a>
        </nav>
    </header>
</template>

<script>
import { mapState, mapMutations } from 'vuex'

export default {
    name: 'Header',

    data() {
        return {
            user_name: '',
        }
    },
    
    computed: {
        ...mapState(['session_store'])
    },

    mounted() {
        this.$nextTick(() => {
            this.getNameUser()
        })
    },

    methods: {
        ...mapMutations(['destroySession']),

        async handleLogout() {

            this.axios.post('logout')
            .then(response => {

                console.log(response.data)
                this.destroySession()
                window.localStorage.removeItem('auth_token')
                window.localStorage.removeItem('auth_user')
                this.$router.push('/login')
            })
            .catch(error => console.log(error))
        },

        getNameUser() {
            const user = this.session_store[0].auth_user
            this.user_name = user.name 
        }
    }
}
</script>

<style lang="scss" scoped>
    header {
        height: 3rem;
        line-height: 3rem;
    }
</style>