<template>
    <main class="main_app">
        <Header />

        <div class="wrapper">
            <div class="left sidebar card-bg py-3 border-right-c">
                    <slot class="search_wrapper" name="search_wrapper"></slot>
                    <slot class="chats_wrapper" name="chats_wrapper"></slot>
            </div>

            <div class="right content">
                <slot class="content_wrapper" name="content"></slot>
            </div>
        </div>
    </main>
</template>

<script>
import Header from '@/components/Home/Header.vue'

export default {
    name: 'AppLayout',
    components: {
        Header
    },

    data() {
        return {
        }
    }
}
</script>

<style lang="scss" scoped>
    $height: 4rem;

    .content {
        height: 100%;
        min-height: calc(100vh - $height);
    }

    .wrapper{
        .left.sidebar {
            float: left;
            max-width: 340px;
            width: 100%;
            height: calc(100vh - 4rem);
        }

        .right.content {
            float: left;
            width: calc(100% - 340px);
            height: calc(100vh - $height);
        }
    }
</style>