import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

// Routes
import login from '@/pages/login/index.vue'
import register from '@/pages/register/index.vue'
import home from '@/pages/home/index.vue'
import profile from '@/pages/profile/index.vue'

const isAuthenticated = () => {
    return window.localStorage.getItem('auth_token')
  }

const routes = [
    { 
        path: '/', 
        component: home, 
        name: 'home'
    },
    { 
        path: '/login', 
        component: login, 
        name: 'login'
    },
    { 
        path: '/register', 
        component: register, 
        name: 'register'
    },
    { 
        path: '/home', 
        component: home, 
        name: 'home_app',
        meta: { isPublic: false }
    },
    { 
        path: '/profile', 
        component: profile, 
        name: 'profile',
        meta: { isPublic: false }
    },
]

const router = new VueRouter({
    mode: 'history', routes
  })
  
// Vue Navigation Guards
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

export default {
    router,
    isAuthenticated
}