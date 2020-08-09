import Vue from 'vue'
import App from '@/pages/root/index.vue'
import axios from 'axios'
import VueAxios from 'vue-axios'
import store from '@/store/index'
import Router from '@/routes/index'

Vue.config.productionTip = false
Vue.use(VueAxios, axios)

// Axios config
if(Router.isAuthenticated) {
    axios.interceptors.request.use(
      config => {
        return {
          ...config,
          baseURL: 'http://localhost:8000/api/',
          headers: {
            'Authorization': Router.isAuthenticated() ? 'Bearer ' + Router.isAuthenticated() : null,
            'Content-Type': 'application/json'
          }
        }
      },
      error => Promise.reject(error)
    )
}

new Vue({
  router: Router.router,
  store,
  render: h => h(App),
}).$mount('#app')
