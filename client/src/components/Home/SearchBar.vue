<template>
    <div class="search_bar d-flex px-3 py-2 rounded-pill secondary-bg">
        <input 
            type="text" 
            placeholder="Buscar personas o chats"
            v-model="search_input"
            @keyup="$emit('search', search_input)">

        <span 
            class="button pointer small" 
            @click="$emit('search', search_input)">
            <font-awesome-icon icon="search" />
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
    }
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