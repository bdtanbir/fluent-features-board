import Vue from 'vue'
import Router from 'vue-router'
import Home from 'ffr_admin/pages/Home.vue'
import Single from 'ffr_admin/pages/Single.vue'

Vue.use(Router)

export default new Router({
    routes: [{
            path: '/',
            name: 'Home',
            component: Home
        },
        {
            path: '/single/:id',
            name: 'Single',
            component: Single,
            props: true
        },
    ]
})