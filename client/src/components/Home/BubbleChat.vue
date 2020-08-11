<template>
    <div class="bubble_wrapper mt-2 d-flex flex-column">
        <div 
            v-bind:class="from === 'me' ? 'text-right ml-auto' : 'text-left'"
            class="from mb-0 text-capitalize small">
        </div>

        <div class="bubble mt-0">
            <div 
                v-bind:class="from === 'me' ? 'primary-bg me text-light drop-left' : 'secondary-bg you text-dynamic drop-right'"
                class="chat_output py-3 px-4 small my-auto">

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
    $rounded-prop: 30px;

    .me {
        width: auto;
        max-width: 45%;
        float: right;
    }

    .you {
        width: auto;
        max-width: 45%;
        float: left;
    }

    .drop-left {
        border-top-left-radius: $rounded-prop;
        border-bottom-left-radius: $rounded-prop;
        border-top-right-radius: $rounded-prop;
    }

    .drop-right {
        border-bottom-right-radius: $rounded-prop;
        border-bottom-left-radius: $rounded-prop;
        border-top-right-radius: $rounded-prop;        
    }
</style>