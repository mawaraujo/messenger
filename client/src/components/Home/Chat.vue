<template>
    <div class="chat_component" id="chat">
        <div class="chat_header d-flex justify-content-between py-3">
            <div class="left my-auto d-flex">
                <div class="content-title">
                    <h1 class="h4 text-dynamic my-auto">{{ contact_name }}</h1>
                </div>
            </div>

            <div class="right my-auto">
                <p class="my-auto h4 pointer">
                    <font-awesome-icon icon="cog" />
                    <!-- <button class="btn btn-light-primary rounded-lg">Opciones del chat</button> -->
                </p>
            </div>
        </div>
        
        <div class="card_body py-3 px-4 d-flex flex-column">
            <div v-for="message in messages" :key="message.id">
                <BubbleChat
                    :from="message.from_id === me.id ? 'me' : 'other'"
                    :message="message.content" />
            </div>
        </div>

        <div 
            class="card_input d-flex align-items-center rounded-lg">
            <div class="textarea border-c my-auto shadow-sm rounded-lg mr-3">
                <textarea 
                    @keyup.enter="submitMessage"
                    v-model="message_field"
                    placeholder="Escribe tu mensaje aquí"
                    class="input_field regular-font pt-3 px-3">
                </textarea>
            </div>

            <div class="submit my-auto">
                <button
                    @click="submitMessage" 
                    class="btn btn-light-primary rounded-pill my-auto px-4">
                    Enviar
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import BubbleChat from '@/components/Home/BubbleChat.vue'
import { mapGetters } from 'vuex'

export default {
    name: 'Chat',

    components: {
        BubbleChat
    },

    props: {
        contact_name: {
            required: true
        },

        contact_id: {
            required: true,
            type: Number
        }
    },

    computed: {
        ...mapGetters(['getUser'])
    },

    data() {
        return {
            message_field: '',
            messages: [],
            me: {},
        }
    },

    async mounted() {
        await this.$nextTick(() => this.me.id = this.getUser.id)
        await this.getMessages()
    },

    watch: {
        contact_id: async function() {
            await this.getMessages()
        }
    },

    methods: {
        async getMessages() {
            this.axios.get(`messages?to_id=${this.contact_id}`)
                .then(response => this.messages = response.data.data)
                .catch(error => console.log(error))
        },

        async submitMessage() {              
            const params = {
                to_id: 2,
                content: this.message_field
            }
            
            this.axios.post('messages', params)   
                .then(response => {
                    this.message_field = ''
                    this.getMessages()
                    return response
                })
                .catch(error => console.log(error))
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
            max-height: 300px;
            height: 100%;
            overflow-y: scroll;
            
            /* Tamaño del scroll */
            &::-webkit-scrollbar {
                width: 10px;
            }

            /* Estilos barra (thumb) de scroll */
            &::-webkit-scrollbar-thumb {
                background: #ccc;
                border-radius: 4px;
            }

            &::-webkit-scrollbar-thumb:active {
                background-color: #999999;
            }

            &::-webkit-scrollbar-thumb:hover {
                background: #b3b3b3;
            }

            /* Estilos track de scroll */
            &::-webkit-scrollbar-track {
                background: #F1F2F7;
                border-radius: 4px;
            }           
        }

        .card_input {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;

            .textarea {
                width: 100%;

                textarea {
                    border: 0;
                    background: none;
                    outline: none;
                    width: 100%;
                    resize: none;

                    /* Tamaño del scroll */
                    &::-webkit-scrollbar {
                        width: 10px;
                        height: 100%;
                    }

                    /* Estilos barra (thumb) de scroll */
                    &::-webkit-scrollbar-thumb {
                        background: #ccc;
                        border-radius: 4px;
                    }

                    &::-webkit-scrollbar-thumb:active {
                        background-color: #999999;
                    }

                    &::-webkit-scrollbar-thumb:hover {
                        background: #b3b3b3;
                    }

                    /* Estilos track de scroll */
                    &::-webkit-scrollbar-track {
                        background: #F1F2F7;
                        border-radius: 4px;
                    }   
                }
            }

            .submit {
                button {
                    margin: auto 0;
                }
            }
        }
    }
</style>