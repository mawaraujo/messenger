<template>
    <div class="chat_component" id="chat">
        <div class="chat_header d-flex justify-content-between py-3">
            <div class="left my-auto d-flex">
                <div class="content-title">
                    <h1 class="h4 text-dynamic my-auto">{{ user_name }}</h1>
                </div>
            </div>

            <div class="right my-auto">
                <p class="my-auto h4 pointer">
                    <font-awesome-icon icon="cog" />
                    <!-- <button class="btn btn-light-primary rounded-lg">Opciones del chat</button> -->
                </p>
            </div>
        </div>
        
        <div class="card_body py-3 px-3 d-flex flex-column">
            <div v-for="message in messages" :key="message.id">
                <BubbleChat
                    :from="message.from"
                    :message="message.message" />
            </div>
        </div>

        <div 
            class="card_input card-bg shadow-sm d-flex rounded-pill px-3">
            <textarea 
                @keyup.enter="submitMessage"
                v-model="message_field"
                class="input_field regular-font my-auto">
            </textarea>

            <button
                @click="submitMessage" 
                class="btn btn-light-primary rounded-pill my-auto px-4">
                Enviar
            </button>
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
    },

    data() {
        return {
            message_field: '',
            messages: [
                {
                    id: 0,
                    message: 'Lorem ipsum dolor it',
                    from: 'me'
                },
                {
                    id: 1,
                    message: 'José Francisco de San Martín y Matorras​ ​ fue un militar y político rioplatense y uno de los libertadores de Argentina, Chile y Perú. En abril de 1784, cuando tenía seis años, llegó con su familia a la ciudad española de Cádiz ―previa estadía en Buenos Aires― y se radicó luego en la ciudad de Málaga',
                    from: 'you'
                },
            ]
        }
    },

    methods: {
        async submitMessage() {
            let chat = document.getElementById('chat-wrapper')

            console.log(this.message_field)
            
            this.messages.push({
                id: Math.random().toString(36).substring(2, 15) + Math.random(),
                message: this.message_field,
                from: 'me'
            })

            window.scrollTo(0, chat.offsetHeight);
            this.message_field = ''
        }
    },
}
</script>

<style lang="scss" scoped>
    //$height: 4rem;

    .chat_component {
        position: relative;
        height: calc(100vh - 6rem);

        .card_header {
            position: relative;
        }

        .card_body {
            width: 100%;
            max-height: 430px;
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