<template>
    <div 
        @click="$emit('clicked', true)"
        class="pointer card_chat secondary-bg-hover d-flex justify-content-between py-3 px-3">

        <div class="content_ch d-flex my-auto">
            <div class="left my-auto rounded-circle mr-2">
                <img 
                    :src="getUrl + image" 
                    class="img-fluid my-auto"
                    alt="Perfil photo">
            </div>

            <div class="right d-flex flex-column my-auto">
                <div class="name-wrapper d-flex">
                    <span 
                        :title="online_status ? 'Conectado' : 'Desconectado'"
                        v-bind:class="online_status ? 'online-bg' : 'secondary-bg'"
                        class="my-auto circle rounded-circle mr-2">
                    </span>
                    <p class="text-dynamic my-auto text-capitalize">{{ name }}</p>
                </div>
                <p class="my-auto small">
                    {{ $truncate(last_message, 20) }}
                </p>
            </div>
        </div>

        <div class="hour my-auto">
            <p class="small my-auto">
                <small>{{ $formatNow(last_time, 'es') }}</small>
            </p>
        </div>
    </div>
</template>

<script>
export default {
    name: 'CardChat',

    props: {
        name: {
            required: true
        },

        image: {
            required: false,
            type: String
        },

        last_message: {
            required: true,
            type: String
        },

        last_time: {
            required: true,
            type: String
        },

        online_status: {
            required: true,
            type: Boolean
        }
    },

    data() {
        return {
            contact_status: false
        }
    },

    computed: {
        getUrl() {
            return process.env.VUE_APP_URL_STORAGE
        }
    },

    created() {
        this.contact_status = this.online_status
    },

    watch: {
        status: function() {
            this.contact_status = this.online_status
        }
    },
}
</script>

<style lang="scss" scoped>
    .card_chat {
        .left {
            width: 40px;
            height: 40px;
            line-height: 40px;
            overflow: hidden;

            img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }
        }

        .right {
            .name-wrapper {
                .circle {
                    width: 10px;
                    height: 10px;
                }
            }
        }
    }
</style>