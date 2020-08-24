<template>
    <main class="main_app">
        <div class="wrapper">
            <div class="first menu card-bg primary-bg d-flex flex-column">
                <Header />
            </div>

            <div class="left sidebar card-bg py-2 border-right-c pt-3">
                    <slot class="search_wrapper mt-3" name="search_wrapper"></slot>
                    <slot class="chats_wrapper" name="chats_wrapper"></slot>
            </div>

            <div class="right content">
                <slot class="content_wrapper" name="content"></slot>
            </div>
        </div>
    </main>
</template>

<script>
import Header from '@/components/Home/Header'

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
    .content {
        height: 100%;
        height: 100vh;
    }

    .wrapper{
        .first {
            float: left;
            max-width: 50px;
            width: 100%;
        }

        .left.sidebar {
            float: left;
            max-width: 320px;
            width: 100%;
            height: 100vh;
        }

        .right.content {
            float: left;
            width: calc(100% - 320px - 50px);
            height: 100vh;
        }
    }
</style>