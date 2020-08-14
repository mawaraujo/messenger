<template>
    <AppLayout 
        @output_search="search_text = $event">

        <!-- Search wrapper -->
        <div class="search px-3" slot="search_wrapper">
            <SearchBar  
                @search="handleSearch"
                @keyup.enter="handleSearch"
                @output="search_text = $event" />
        </div>

        <!-- Chats wrapper -->
        <div class="chats mt-3" slot="chats_wrapper">
            <template v-for="conversation in conversations">
                <CardChat
                    :key="conversation.id"
                    @clicked="handleChat(conversation.contact)" 
                    :name="conversation.contact.name"
                    :last_message="conversation.last_message"
                    :last_time="conversation.last_time.split(' ')[1]"
                />
            </template>
        </div>

        <!-- Main chat wrapper -->
        <div class="container-fluid card-bg" slot="content">
            <div class="row">
                <div class="col-12 py-3" v-if="selected_chat.name.length > 0">
                    <Chat 
                        :contact_id="selected_chat.id"
                        :contact_name="selected_chat.name"
                        :contact_chat_status="selected_chat.chat_status" 
                        @sending="getConversations()" />
                </div>

                <!-- Convertir en un componente -->
                <div class="col-12" v-else>
                   <EmptyChat />
                </div>
                <!-- Convertir en un componente -->
            </div>
        </div>
    </AppLayout>

</template>

<script>
import AppLayout from '@/layouts/AppLayout.vue'
import SearchBar from '@/components/Home/SearchBar.vue'
import CardChat from '@/components/Home/CardChat.vue'
import EmptyChat from '@/components/Home/EmptyChat.vue'
import Chat from '@/components/Home/Chat.vue'

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
                chat_status: ''
            },
            conversations: []
        }
    },

    watch: {
        search_text: function() {
            console.log(this.search_text)
        }
    },

    async mounted() {
        // this.getCurrentUser()
        await this.getConversations()
    },

    methods: {
        handleSearch() {
            console.log(this.search_text + ' desde index.vue')
        },

        handleChat(contact) {
            this.selected_chat.id = contact.id
            this.selected_chat.name = contact.name
            this.selected_chat.chat_status = contact.chat_status
        },

        async getCurrentUser() {
            try {
                const response = await this.axios.get('user') 
                const data = response.data
                console.log(data)
            } catch (error) {
                console.log(error)
            }
        },

        async getConversations() {
            try {
                const response = await this.axios.get('conversations')
                const store = response.data
                this.conversations = store.data
            } catch (error) {
                console.log(error)
            }
        }
    },
}
</script>

<style lang="scss" scoped></style>