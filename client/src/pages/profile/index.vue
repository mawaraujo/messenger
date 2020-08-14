<template>
    <main class="profile_page">
        <Header />

        <section class="container d-flex align-items-center">
            <div class="row shadow py-5 card-bg d-flex flex-column">

                <div class="col-md-4 mx-auto profile-data text-center my-4" v-if="set_change === 0">
                    <div class="profile_image rounded-circle mx-auto mb-3">
                        <img 
                            src="@/static/default_people.png" 
                            alt="Profile photo">    
                    </div>

                    <h1 class="text-dynamic text-capitalize my-auto">{{user.name}}</h1>
                    <div>{{user.chat_status}}</div>
                </div>

                <div class="col-md-6 mx-auto px-5 d-flex justify-content-center align-items-center">
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
                        </div>
                    </template>

                    <template v-if="set_change === 1">
                        <ChangeProfileInfo 
                            :user_name="user.name"
                            :user_email="user.email" 
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
            is_error: false,
            set_change: 0
        }
    },

    computed: {},

    mounted() {
        this.getCurrentUser()
    },

    methods: {
        getCurrentUser() {
            this.axios.get('user')
            .then(res => this.user = res.data)
            .catch(error => {
                this.is_error = true
                this.error = error
            })
        },

        handleStatus() {
            this.$refs.input_status.blur()
            console.log(this.user.chat_status)
        },

        selectEmoji(emoji) {
            console.log(emoji)
        }
    },
}
</script>

<style lang="scss" scoped>
    .container {
        height: calc(100vh - 4rem);

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