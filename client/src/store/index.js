import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
    state: {
        session_store: [] 
    },

    mutations: {
      createSession: (state, data) => {
        state.session_store = []
        state.session_store.push(data)
      },
      
      updateSession: state => {
        state.session_store.push({
          auth_token: window.localStorage.getItem('auth_token'),
          auth_user: JSON.parse(window.localStorage.getItem('auth_user'))
        })
      },

      destroySession: state => {
        state.session_store = []
      },

      changeUserData: (state, values) => {
        console.log(values.image)
        state.session_store[0].auth_user.name = values.name
        state.session_store[0].auth_user.image = values.image
        state.session_store[0].auth_user.chat_status = values.chat_status
        window.localStorage.auth_user = JSON.stringify(state.session_store[0].auth_user)
      }
    },

    getters: {
      getUser: state => {
        return state.session_store[0].auth_user
      },
      getToken: state => {
        return state.session_store[0].auth_token
      }
    },

    actions: {}
})