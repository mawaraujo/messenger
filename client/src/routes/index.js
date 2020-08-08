import home from '@/pages/home/index.vue'
import login from '@/pages/login/index.vue'
import register from '@/pages/register/index.vue'

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
]

export default routes