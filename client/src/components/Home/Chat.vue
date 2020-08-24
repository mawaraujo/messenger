<template>
    <div class="chat_component" id="chat">
        <div class="chat_header card-bg px-3 d-flex justify-content-between align-items-center py-2">
            <div class="left d-flex">
                
                <div class="sub-left mr-3 my-auto">
                    <router-link
                        :title="'Ir al perfil de ' + contact_name"
                        :to="`/profile/${contact_id}`">
                        
                        <div class="profile_image rounded-circle mx-auto pointer">
                            <img 
                                :src="getUrl + contact_image" 
                                alt="Profile photo">    
                        </div>
                    </router-link>
                </div>

                <div class="sub-right">
                    <div class="content-title text-capitalize">
                        <router-link 
                        :title="'Ir al perfil de ' + contact_name"
                        :to="`/profile/${contact_id}`">
                            <h6 class="text-dynamic my-auto">{{ contact_name }}</h6>
                        </router-link>

                        <p class="small my-auto">
                            <small>{{is_online == true ? 'En linea' : contact_chat_status }}</small>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        
        <div ref="chat_body" class="card_body py-3 px-4 d-flex flex-column mt-2">
            <div v-for="message in messages" :key="message.id">
                <BubbleChat
                    :from="message.from_id === me.id ? 'me' : 'other'"
                    :message="message.content" />
            </div>
        </div>

        <div class="card_input d-flex align-items-center rounded-lg py-2">
            <div class="textarea my-auto rounded-lg mx-3 card-blur-bg d-flex">
                <textarea 
                    @keyup.enter="submitMessage"
                    v-model="message_field"
                    placeholder="Escribe tu mensaje aquí"
                    class="input_field regular-font pt-3 px-3">
                </textarea>

                <button
                    @click="submitMessage" 
                    class="btn btn-primary rounded-lg my-auto mr-3">
                    Enviar
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import BubbleChat from '@/components/Home/BubbleChat.vue'
import { mapGetters } from 'vuex'
import Pusher from 'pusher-js';

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
        },

        contact_chat_status: {
            required: true,
            type: String
        },

        contact_image: {
            required: true,
            type: String
        },

        online_status: {
            required: true,
            type: Boolean
        }
    },

    computed: {
        ...mapGetters(['getUser', 'getToken']),

        getUrl() {
            return process.env.VUE_APP_URL_STORAGE
        }
    },

    data() {
        return {
            message_field: '',
            messages: [],
            me: {}, 
            is_online: false
        }
    },

    async mounted() {
        if(navigator.onLine) this.is_online = true
        else this.is_online = false
        this.handleScrollToBottom()
        await this.$nextTick(() => this.me.id = this.getUser.id)
        await this.initialize()
        await this.getMessages()
    },

    watch: {
        contact_id: async function() {
            await this.getMessages()
        }
    },

    updated() {
        this.handleScrollToBottom()
        this.online_status === true ? this.is_online = true : this.is_online = false
    },

    methods: {
        initialize() {
            const pusher = new Pusher(process.env.VUE_APP_PUSHER_KEY, {
                authEndpoint: `http://localhost:8000/broadcasting/auth`,
                cluster: process.env.VUE_APP_PUSHER_CLUSTER,
                enableStats: false,
                auth: {
                    headers: {
                        Authorization: 'Bearer ' + this.getToken
                    },
                },
                encrypted: true
            })

            const messageChannel = pusher.subscribe(`private-users.${this.me.id}`);

            messageChannel.bind('new.message', data => {
                this.addMessage(data.message)
                this.handleEmitSending(data.message)
            })
        },

        async getMessages() {
            this.axios.get(`messages?to_id=${this.contact_id}`)
                .then(response => this.messages = response.data.data)
                .catch(error => console.log(error)) 
        },

        async submitMessage() {              
            const params = {
                to_id: this.contact_id,
                content: this.message_field
            }
            
            this.axios.post('messages', params)   
                .then(response => {
                    this.message_field = ''
                    this.addMessage(response.data.data)
                    this.handleEmitSending(response.data.data)
                    this.handleScrollToBottom()
                    
                })
                .catch(error => console.log(error))
        },

        handleScrollToBottom() {
            this.$refs.chat_body.scrollTop = this.$refs.chat_body.scrollHeight * 100
        },

        handleEmitSending(data) {
            this.$emit('sending', data)
        },

        addMessage(message) {
            // Si la conversación seleccionada coincide con quien nos envio el mensaje
            // O si es un mensaje que nosotros enviamos al contacto
            if(this.contact_id === message.from_id || this.contact_id === message.to_id) {
                this.messages.push(message)
            }
        }
    },
}
</script>

<style lang="scss" scoped>
    .chat_component {
        height: 100%;

        .chat_header {
            .profile_image {
                width: 40px;
                height: 40px;
                overflow: hidden;

                img {
                    object-fit: cover;
                    width: 100%;
                    height: 100%;
                }
            }
        }

        .card_body {
            scroll-behavior: smooth;   
            width: 100%;
            height: calc(100vh - 9.9rem);
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