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
                    @clicked="handleChat(conversation.contact_id, conversation.contact_id)" 
                    :name="conversation.contact_id"
                    last_message="Lorem ipsum dolor it"
                    last_time="10:45 PM"
                />
            </template>
        </div>

        <!-- Main chat wrapper -->
        <div class="container-fluid card-bg" slot="content">
            <div class="row">
                <div class="col-12 py-3" v-if="selected_chat.id !== ''">
                    <Chat 
                        :contact_id="selected_chat.id"
                        :contact_name="selected_chat.id" />
                </div>

                <!-- Convertir en un componente -->
                <div class="col-12 py-3 empty chat" v-else>
                    <p>Selecciona un chat para continuar</p>
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
import Chat from '@/components/Home/Chat.vue'

export default {
    name: 'Home',
    components: {
       AppLayout,
       SearchBar,
       CardChat,
       Chat
    },

    data() {
        return {
            search_text: '',
            selected_chat: {
                id: '',
                name: ''
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

        handleChat(id, name) {
            this.selected_chat.id = id
            this.selected_chat.name = name
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