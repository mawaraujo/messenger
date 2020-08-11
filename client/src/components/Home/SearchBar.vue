<template>
    <div class="search_bar d-flex px-3 py-1 rounded-pill secondary-bg">
        <input 
            type="text" 
            placeholder="Buscar personas o chats"
            v-model="search_input"
            @change="handleSearch">

        <span 
            class="button pointer" 
            @click="$emit('search', true)">
            O
        </span>
    </div>
</template>

<script>
export default {
    name: 'Search',
    data() {
        return {
            search_input: ''
        }
    },

    methods: {
        handleSearch() {
            this.$emit('output', this.search_input)
        }
    },
}
</script>

<style lang="scss" scoped>
    .search_bar {
        width: 100%; 

        input {
            border: 0;
            background: none;
            outline: none;
            width: 100%;
        }
    }
</style>