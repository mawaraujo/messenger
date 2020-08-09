<template>
    <div class="bubble_wrapper mt-3 d-flex flex-column">
        <div 
            v-bind:class="from === 'me' ? 'text-right' : 'text-left'"
            class="from mb-0 text-capitalize small">
            <p class="mb-0">{{ from === 'me' ? 'Tú' : from}}</p>
        </div>

        <div class="bubble mt-0 ounded-lg">
            <div 
                v-bind:class="from === 'me' ? 'primary-bg me text-light' : 'secondary-bg you text-dynamic'"
                class="chat_output py-2 px-4 rounded-lg small my-auto">

                {{ message }}
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'Bubble',
    
    props: {
        from: {
            required: true,
            type: String
        },
        
        message: {
            required: true,
            type: String
        }
    }
}
</script>

<style lang="scss" scoped>
    .me {
        width: 55%;
        float: right;    
    }

    .you {
        width: 55%;
        float: left;
    }
</style>