<template>
    <header class="navbar_client d-flex justify-content-end fixed-top px-3">
        <router-link 
            :to="link_to">
            {{ name_to }}
        </router-link>
    </header>
</template>

<script>
export default {
    name: 'NavbarClient',
    
    props: {
        link_to: {
            required: false,
            type: String
        },

        name_to: {
            required: false,
            type: String
        }
    }
}
</script>

<style lang="scss" scoped>
    header {
        height: 3rem;
        line-height: 3rem;
    }
</style>