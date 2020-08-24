import Vue from 'vue'
import App from '@/pages/root/index.vue'
import axios from 'axios'
import VueAxios from 'vue-axios'
import store from '@/store/index'
import Router from '@/routes/index'
import { library } from '@fortawesome/fontawesome-svg-core'
import { faEllipsisV, faArrowLeft, faSearch, faUser, faSignOutAlt, faHome } from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

//Custom plugins
import FormatNow from '@/plugins/format_now'
import Truncate from '@/plugins/truncate'
import EventBus from '@/plugins/event_bus'

library.add(faEllipsisV, faArrowLeft, faSearch, faUser, faSignOutAlt, faHome)

Vue.config.productionTip = false
Vue.use(FormatNow)
Vue.use(Truncate)
Vue.use(EventBus)
Vue.use(VueAxios, axios)
Vue.component('font-awesome-icon', FontAwesomeIcon)
// Axios config
if(Router.isAuthenticated) {
    axios.interceptors.request.use(
      config => {
        return {
          ...config,
          baseURL: process.env.VUE_APP_URL,
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
