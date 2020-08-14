<template>
    <div 
        class="
        profile_data 
        py-3 
        d-flex 
        flex-column
        h-100
        justify-content-center 
        align-items-center">

        <div class="profile-name text-center py-5">
            <h1 class="text-light text-capitalize my-auto">{{profile_name}}</h1>
            <p class="subtitle my-auto text-light">{{profile_chat_status}}</p>
        </div>
    </div>
</template>

<script>
export default {
    name: 'PerfilPreview',

    props: {
        profile_name: {
            required: true
        },

        profile_chat_status: {
            required: true
        },
        
        profile_photo: {
            required: false
        }
    },

    data() {
        return {}
    }
}
</script>

<style lang="scss" scoped>
    .profile_data {
        height: 100%; 
        
        .profile-photo {
            width: 160px;
            height: 160px;
            overflow: hidden;

            img {
                object-fit: cover;
                width: 100%;
                height: 100%;
            }
        }
    }
</style>