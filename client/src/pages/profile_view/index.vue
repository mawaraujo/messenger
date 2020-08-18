<template>
    <main class="profile-view container-fluid card-bg">
        <Header />

        <div class="row d-flex align-items-center py-5">
            <div class="col-12 text-center">
                    <div class="profile_image rounded-circle mx-auto mb-3">
                        <img 
                            :src="getUrl + data.image" 
                            alt="Profile photo">    
                    </div>

                <h1 class="text-dynamic text-capitalize">{{data.name}}</h1>
                <p class="">{{data.chat_status}}</p>

                <button 
                    @click="handleAdd"
                    class="btn btn-primary rounded-pill px-4">
                    Añadir amigo
                </button>
            </div>
        </div>
    </main>
</template>

<script>
import Header from '@/components/Home/Header'

export default {
    name: 'ProfileView',

    components: {
        Header
    },

    computed: {
        getId() {
            return this.$route.params.id
        },

        getUrl() {
            return process.env.VUE_APP_URL_STORAGE
        }   
    },

    data() {
        return {
            error_fetch: false,
            data: []
        }
    },

    mounted() {
        this.getUser()   
    },

    methods: {
        async getUser() {
            try {
                const response = await this.axios.get(`users/${this.getId}`)
                this.data = response.data.data
            } catch(error) {
                console.log(error)
                this.error_fetch = true
            }
        },

        async handleAdd() {
            console.log('Added')
        }
    },
}
</script>

<style lang="scss" scoped>
    .container-fluid {
        .row {
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
    }
</style>