require('./bootstrap');
window.Vue = require('vue').default;

import Vue from 'vue'
import router from "./router";
import Layout from "./Layout";
import VueRouter from 'vue-router';


import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
Vue.use(VueRouter);
Vue.use(BootstrapVue);
Vue.use(IconsPlugin);

new Vue({
    router,
    render: h => h(Layout)
}).$mount('#app');
