<template>
    <div class="change-profile-info container-fluid py-4">
        <div class="back mb-4 pointer h4 d-flex" @click="$emit('back', true)" title="Ir hacia atrás">
            <span class="my-auto mr-3">
                    <font-awesome-icon icon="arrow-left" />
            </span>

            <p class="h5 my-auto">Volver</p>
        </div>

        <form>
            <fieldset class="form-items">
                <div class="profile_image rounded-circle mx-auto mb-2">
                    <img 
                        :src="getUrl + form_fields.image" 
                        alt="Profile photo">
                </div>
            </fieldset>

            <fieldset class="form-items">
                <label class="small" for="profile_photo">Imagen de perfil</label>
                <input 
                class="control regular" 
                type="file" 
                id="profile_photo"
                ref="file"
                @change="handleImage()">
            </fieldset>

            <fieldset class="form-items">
                <label class="small" for="name">Nombre completo</label>
                <input 
                class="control regular" 
                type="text" 
                id="name"
                v-model="form_fields.name">
            </fieldset>

            <fieldset class="form-items">
                <label class="small" for="email">Correo electrónico</label>
                <input 
                disabled
                class="control regular" 
                type="email" 
                id="email"
                v-model="form_fields.email">
            </fieldset>

            <div class="submit text-right">
                <button 
                    @click.prevent="handleSubmit"
                    class="btn btn-primary rounded-pill px-3">
                    Actualizar datos
                </button>
            </div>
        </form>
    </div>
</template>

<script>
import { mapMutations } from 'vuex'
export default {
    name: 'ChangeProfileInfo',

    props: {
        user_id: {
            required: true
        },

        user_name: {
            required: true,
            type: String
        },

        user_email: {
            required: true,
            type: String
        },

        user_image: {
            required: false,
            type: String
        }
    },

    data() {
        return {
            form_fields: {
                id: '',
                name: '',
                email: '',
                image: '',
                image_file: ''
            }
        }
    },

    computed: {
        getUrl() {
            return process.env.VUE_APP_URL_STORAGE
        }
    },

    created() {
        this.form_fields.id = this.user_id
        this.form_fields.name = this.user_name
        this.form_fields.email = this.user_email
        this.form_fields.image = this.user_image
    },

    methods: {
        ...mapMutations(['changeUserData']),

        async handleSubmit() {
            try {
                const formData = new FormData()
                formData.append('name', this.form_fields.name)
                formData.append('image', this.form_fields.image_file)
                formData.append("_method", "PUT")

                const response = await this.axios.post(`users/${this.user_id}`, formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }                
                })

                this.form_fields.image = response.data.data.image          
                this.changeUserData(response.data.data)
                this.$emit('sucessDataChanged', response.data.data)     
            } catch (error) {
                console.log(error)
            }
        },

        handleImage() {
            this.form_fields.image_file = this.$refs.file.files[0];
        }
    }
}
</script>

<style lang="scss" scoped>
    .profile_image {
        width: 160px;
        height: 160px;
        overflow: hidden;

        img {
            object-fit: cover;
            width: 100%;
            height: 100%;
        }
    }
</style>