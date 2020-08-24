<template>
  <div id="app">
    <router-view></router-view>
  </div>
</template>

<script>
import '@/assets/css/app.css'
import '@/assets/css/mawui.min.css'
import { mapMutations } from 'vuex'

export default {
  name: 'App',
  components: {},

  mounted() {
    this.updateSession()
  },

  methods: {
    ...mapMutations(['updateSession'])
  }
}
</script>

<style>
  @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,700;1,400&display=swap');

  body {
    font-family: 'Poppins', sans-serif;
  }

  .regular-font {
    font-family: 'Poppins', sans-serif;
  }
</style>
