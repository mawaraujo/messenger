<template>
    <AppLayout>
        <!-- Search wrapper -->
        <div class="search px-3" slot="search_wrapper" v-if="conversations.length">
            <SearchBar  
                @search="search_text = $event" />
        </div>

        <!-- Chats wrapper -->
        <div class="chats mt-3" slot="chats_wrapper" v-if="conversations.length">
            <template v-for="conversation in conversationsFiltered">
                <CardChat
                    v-bind:class="{'secondary-bg': conversation.contact.id === selected_chat.id}"
                    :key="conversation.id"
                    @clicked="handleChat(conversation.contact, conversation.online_status)" 
                    :name="conversation.contact.name"
                    :image="conversation.contact.image"
                    :online_status="conversation.online_status && conversation.online_status === true ? conversation.online_status : false"
                    :last_message="conversation.last_message"
                    :last_time="conversation.last_time"
                />
            </template>
        </div>

        <div class="chats my-5 text-center" slot="chats_wrapper" v-else>
            <p>Sin conversaciones activas</p>

            <button class="btn btn-light-primary rounded-pill px-4">
                <small>Añade una conversación</small>
            </button>
        </div>

        <!-- Main chat wrapper -->
        <div 
            v-bind:class="current_user.chat_background ? changeChatBackground() : 'card-bg'"
            id="chat-wrapper"
            slot="content">

            <div class="" v-if="selected_chat.name.length > 0">
                <Chat 
                    :contact_id="selected_chat.id"
                    :contact_name="selected_chat.name"
                    :contact_image="selected_chat.image"
                    :contact_chat_status="selected_chat.chat_status" 
                    :online_status="selected_chat.online_status && selected_chat.online_status === true ? selected_chat.online_status : false"
                    @sending="getConversations()" />
            </div>

            <!-- Convertir en un componente -->
            <div v-else>
                <EmptyChat />
            </div>
             <!-- Convertir en un componente -->
        </div>
    </AppLayout>

</template>

<script>
import AppLayout from '@/layouts/AppLayout.vue'
import SearchBar from '@/components/Home/SearchBar.vue'
import CardChat from '@/components/Home/CardChat.vue'
import EmptyChat from '@/components/Home/EmptyChat.vue'
import Chat from '@/components/Home/Chat.vue'
import Pusher from 'pusher-js';
import { mapGetters } from 'vuex'

export default {
    name: 'Home',
    components: {
       AppLayout,
       SearchBar,
       CardChat,
       EmptyChat,
       Chat
    },

    data() {
        return {
            search_text: '',
            selected_chat: {
                id: '',
                name: '',
                chat_status: '',
                online_status: false,
            },
            conversations: [],
            current_user: []
        }
    },

    computed: {
        ...mapGetters(['getToken', 'getUser']),

        conversationsFiltered() {
            return this.conversations.filter((conversation) => {
                if(this.search_text.length > 0) return conversation.contact.name.includes(this.search_text)
                else return conversation
            })
        },

        getUrl() {
            return process.env.VUE_APP_URL_STORAGE
        }
    },

    async mounted() {
        await this.getConversations()
        this.$nextTick(() => {
            this.initialize()
            this.current_user = this.getUser
        })
    },

    methods: {
        handleChat(contact, status) {
            this.selected_chat.id = contact.id
            this.selected_chat.name = contact.name
            this.selected_chat.chat_status = contact.chat_status
            this.selected_chat.image = contact.image
            this.$set(this.selected_chat, 'online_status', status)
        },

        async getConversations() {
            try {
                const response = await this.axios.get('conversations')
                const store = response.data
                this.conversations = store.data
            } catch (error) {
                console.log(error)
            }
        },

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
            
            const presenceChannel = pusher.subscribe(`presence-messenger`);

            presenceChannel.bind("pusher:subscription_succeeded", members => {
                members.each(member => this.addOnlineStatus(member.id, true))
            })

            presenceChannel.bind("pusher:member_added", member => this.addOnlineStatus(member.id, true))
            presenceChannel.bind("pusher:member_removed", member => this.addOnlineStatus(member.id, false))
        },

        addOnlineStatus(member_id, status) {
            this.conversations.map(conversation => {
                if(conversation.contact.id === parseInt(member_id)) {
                    if(status === true) this.$set(conversation, 'online_status', true)
                    else this.$set(conversation, 'online_status', false)
                }
            })
        },

        changeChatBackground() {
            document.getElementById('chat-wrapper').style.background = `url('${this.getUrl}${this.current_user.chat_background}')`
        },
    },
}
</script>

<style lang="scss" scoped>
    .container-fluids {
        width: 100%;
        height: 100%;
    }
</style>