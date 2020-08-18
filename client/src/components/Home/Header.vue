<template>
    <header class="px-3 d-flex justify-content-between card-bg border-bottom-c">
        <div class="branding">
            <router-link to="/home" class="text-capitalize">
                <div class="img-wrapper d-flex align-items-center" title="Mi perfil">
                    <img 
                        src="@/static/brand.png" 
                        width="100%" 
                        alt="Brand">
                </div>
            </router-link>
        </div>

        <nav class="navigation d-flex">
            <router-link 
                to="/home" 
                class="text-capitalize mr-3">

                Inicio
            </router-link>

            <router-link 
                to="/profile" 
                class="text-capitalize">

                <div class="profile-image">
                    <img 
                        :src="getUrl + user_image" 
                        alt="Profile image">
                </div>
            </router-link>
        </nav>
    </header>
</template>

<script>
import { mapState } from 'vuex'

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
        getUser() {
            const user = this.session_store[0].auth_user
            this.user_name = user.name 
            this.user_image = user.image
        }
    }
}
</script>

<style lang="scss" scoped>
    header {
        height: 4rem;
        line-height: 4rem;

        .img-wrapper{
            width: 40px;
            height: 100%;

            img {
                margin: auto 0;
                width: 100%;
            }
        }

        .profile-image {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            overflow: hidden;
            margin-top: calc(2rem - 50%);

            img {
                object-fit: cover;
                width: 100%;
                height: 100%;
            }
        }
    }
</style>