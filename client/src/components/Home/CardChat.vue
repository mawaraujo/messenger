<template>
    <div 
        @click="$emit('clicked', true)"
        class="pointer card_chat border-bottoms d-flex justify-content-between py-3 px-3 mt-3">

        <div class="content_ch d-flex my-auto">
            <div class="left my-auto rounded-circle mr-2">
                <img 
                    :src="image ? image : '../../static/default_people.png'" 
                    class="img-fluid my-auto"
                    alt="Perfil photo">
            </div>

            <div class="right d-flex flex-column my-auto">
                <p class="text-dynamic my-auto">{{ name }}</p>
                <p class="my-auto small">
                    <small>{{ last_message }}</small>
                </p>
            </div>
        </div>

        <div class="hour my-auto">
            <p class="small my-auto">{{ last_time }}</p>
        </div>
    </div>
</template>

<script>
export default {
    name: 'CardChat',

    props: {
        name: {
            required: true,
            type: String
        },

        image: {
            required: false,
            type: String
        },

        last_message: {
            required: true,
            type: String
        },

        last_time: {
            required: true,
            type: String
        }
    }
}
</script>

<style lang="scss" scoped>
    .card_chat {
        .left {
            width: 50px;
            height: 50px;
            line-height: 50px;
            overflow: hidden;

            img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }
        }

        &:hover {
            background: rgb(240, 240, 240);
        }
    }

    .border-bottoms {
        border-bottom: 1px solid rgb(240, 240, 240);
    }
</style>