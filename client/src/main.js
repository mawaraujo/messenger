import Vue from 'vue'
import App from '@/pages/root/index.vue'
import VueRouter from 'vue-router'
import axios from 'axios'
import VueAxios from 'vue-axios'
import routes from '@/routes/index'
import store from '@/store/index'

const isAuthenticated = () => {
  return window.localStorage.getItem('auth_token')
}

Vue.config.productionTip = false
Vue.use(VueRouter)
Vue.use(VueAxios, axios)

const router = new VueRouter({
  mode: 'history', routes
})

router.beforeEach((to, from, next) => {
  if(to.meta.isPublic === false && !isAuthenticated()) {
    return next({ path: '/login' })
  }

  if(to.name === 'login' && isAuthenticated()) {
    return next({ path: '/home' })
  }

  if(to.name === 'register' && isAuthenticated()) {
    return next({ path: '/home' })
  }

  return next()
})  

if(isAuthenticated) {
    axios.interceptors.request.use(
      config => {
        return {
          ...config,
          headers: {
            'Authorization': isAuthenticated() ? isAuthenticated() : null,
            'Content-Type': 'application/json'
          }
        }
      },
      error => Promise.reject(error)
    )
}

new Vue({
  router,
  store,
  render: h => h(App),
}).$mount('#app')
