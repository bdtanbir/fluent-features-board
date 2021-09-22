import Vue from 'vue'
import App from './App.vue'
import router from './router'
import VTooltip from 'v-tooltip'

Vue.use(VTooltip)

Vue.config.productionTip = false

/* eslint-disable no-new */
new Vue({
    el: '#fluent-features-board-app',
    router,
    render: h => h(App)
});