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
        <div class="chats" slot="chats_wrapper">
            <CardChat
                @clicked="handleChat(33)" 
                name="Jhon Doe"
                last_message="Lorem ipsum dolor it"
                last_time="10:45 PM"
            />
        </div>

        <!-- Main chat wrapper -->
        <div class="container-fluid" slot="content">
            <div class="row">
                <div class="col-12 py-3">
                    <Chat 
                        :user_id="2"
                        user_name="Jhon Doe"
                        user_chat_status="Aburrido!" />
                </div>
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
            search_text: ''
        }
    },

    watch: {
        search_text: function() {
            console.log(this.search_text)
        }
    },

    mounted() {
        this.getCurrentUser()
    },

    methods: {
        handleSearch() {
            console.log(this.search_text + ' desde index.vue')
        },

        handleChat(id) {
            console.log(id)
        },

        async getCurrentUser() {
            try {
                console.log('Current-user')
                // const response = await this.axios.get('http://localhost:8000/api/users') 
                // const data = response.data
                // console.log(data)
            } catch (error) {
                console.log(error)
            }
        }
    },
}
</script>

<style lang="scss" scoped></style>