<template>
    <main class="profile_page">
        <Header />

        <section class="container-fluid card-bg py-3 px-5">
            <div class="row">
                <div class="col-12">
                    <h1 v-if="user">
                        {{user.name}}
                    </h1>
                </div>
            </div>
        </section>

    </main>
</template>

<script>
import Header from '@/components/Home/Header'

export default {
    name: 'Profile',

    components: {
        Header
    },

    data() {
        return {
            user: [],
            error: [],
            is_error: false
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
        }
    },
}
</script>