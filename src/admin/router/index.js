import Vue from 'vue'
import Router from 'vue-router'
import Home from 'admin/pages/Home.vue'
import Single from 'admin/pages/Single.vue'

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