import Vue from 'vue'
import Router from 'vue-router'
import Home from 'frontend/pages/Home.vue'
import Another from 'frontend/pages/Another.vue'

Vue.use(Router)

export default new Router({
    routes: [{
            path: '/',
            name: 'Home',
            component: Home
        },
        {
            path: '/another',
            name: 'Another',
            component: Another
        },
    ]
})