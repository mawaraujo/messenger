<template>
    <div class="chat_component">
        <div class="chat_header d-flex justify-content-between border-bottom">
            <div class="left my-auto d-flex">
                <div class="content-title">
                    <h1 class="h4 text-dynamic my-auto">{{ user_name }}</h1>
                    <p class="my-auto small">{{ user_chat_status }}</p>
                </div>
            </div>

            <div class="right my-auto">
                <p class="my-auto small pointer">
                    Opciones
                </p>
            </div>
        </div>
        
        <div class="card_body py-3 px-3 d-flex flex-column">
            <BubbleChat
                from="me"
                message="Lorem ipsum dolor sit amet consectetur adipisicing elit. Dignissimos, labore" />

            <BubbleChat
                from="jhon"
                message="Lorem ipsum dolor sit amet consectetur adipisicing elit. Dignissimos, labore" />
        </div>

        <div class="card_input card-bg shadow-sm d-flex rounded-lg px-3">
            <textarea class="input_field regular-font my-auto"></textarea>
            <button class="btn btn-link my-auto">Enviar</button>
        </div>
    </div>
</template>

<script>
import BubbleChat from '@/components/Home/BubbleChat.vue'

export default {
    name: 'Chat',

    components: {
        BubbleChat
    },

    props: {
        user_id: {
            required: true,
            type: Number
        },

        user_name: {
            required: true,
            type: String
        },

        user_chat_status: {
            required: true,
            type: String
        }
    }
}
</script>

<style lang="scss" scoped>
    .chat_component {
        position: relative;
        height: calc(100vh - 5rem);

        .card_header {
            position: relative;
        }

        .card_body {
            width: 100%;
            max-height: 400px;
            height: 100%;
            overflow-y: scroll;
        }

        .card_input {
            border: 1px solid rgb(240, 240, 240);
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;

            textarea {
                border: 0;
                background: none;
                outline: none;
                width: 100%;
                max-width: 100%;
                resize: none;
                height: 60px;
                line-height: 60px;
            }
        }
    }
</style>