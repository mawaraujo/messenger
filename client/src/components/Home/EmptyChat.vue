<template>
    <div class="empty-chat d-flex flex-column align-items-center justify-content-center">
        <p class="h3 text-capitalize">Hola, {{name}}</p>
        <h2 class="title text-dynamic h3">Inicia una conversación para continuar</h2>
    </div>
</template>

<script>
import { mapGetters } from 'vuex'
export default {
    name: 'EmptyChat',

    data() {
        return {
            name: ''
        }
    },

    computed: {
        ...mapGetters(['getUser'])
    },

    mounted() {
        this.$nextTick(() => this.name = this.getUser.name)
    }
}
</script>

<style lang="scss" scoped>
    .empty-chat {
        height: 100vh;
        width: 100%;
    }
</style>