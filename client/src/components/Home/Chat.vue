<template>
    <div class="chat_component">
        <div class="chat_header d-flex justify-content-between border-bottom">
            <div class="left my-auto d-flex">
                <div class="content-title">
                    <h1 class="h4 text-dynamic my-auto">{{ user_name }}</h1>
                    <p class="my-auto small">{{ user_chat_status }}</p>
                </div>
            </div>

            <div class="right my-auto">
                <p class="my-auto small pointer">
                    Opciones
                </p>
            </div>
        </div>
        
        <div class="card_body py-3 d-flex flex-column">
            <div class="you mt-3 bubble_you">
                <p class="chat_output text-light py-2 px-4 rounded-lg small my-auto">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Dignissimos, labore
                </p>
            </div>

            <div class="other mt-3">
                <p class="chat_output py-2 px-4 rounded-lg small my-auto text-dynamic">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Dignissimos, labore
                </p>
            </div>
        </div>

        <div class="card_input card-bg shadow-sm d-flex rounded-lg px-3">
            <textarea class="input_field regular-font my-auto"></textarea>
            <button class="btn btn-link my-auto">Enviar</button>
        </div>
    </div>
</template>

<script>
export default {
    name: 'Chat',
    props: {
        user_id: {
            required: true,
            type: Number
        },

        user_name: {
            required: true,
            type: String
        },

        user_chat_status: {
            required: true,
            type: String
        }
    }
}
</script>

<style lang="scss" scoped>
    .chat_component {
        height: calc(100vh - 5rem);
        position: relative;
        z-index: 103;

        .card_header {
            z-index: 101;
            position: relative;
        }


        .card_body {
            z-index: 102;
            position: absolute;
            bottom: 65px;
            left: 0;
            width: 100%;
            max-height: 400px;

            @media(max-height: 400px) {
                & {
                    overflow-y: scroll;
                }
            }

            .you {
                align-self: flex-end;
                text-align: end;
                display: inline;
                background: #4479FD;          
            }

            .other {
                align-self: start;
                text-align: start;
                display: inline;
                background: #e0e0e0;
            }
        }

        .card_input {
            border: 1px solid rgb(240, 240, 240);
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;

            textarea {
                border: 0;
                background: none;
                outline: none;
                width: 100%;
                max-width: 100%;
                resize: none;
                height: 60px;
                line-height: 60px;
            }
        }
    }
</style>