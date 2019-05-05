
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import Vue from 'vue'
import VueRouter from 'vue-router'
import Vuetify from 'vuetify';
import auth from './service/Auth'
import store from './store'
import axios from 'axios';
//import VueAxios from 'vue-axios';
import { routes } from './routes'
//import { setupComponents } from './setup-components';
//import Controller from './httpController'

import 'vuetify/dist/vuetify.min.css';
import 'font-awesome/css/font-awesome.min.css';
import 'font-awesome/css/font-awesome.css';


import App from './components/App'

//setupComponents(Vue);
Vue.use(VueRouter);
Vue.use(Vuetify);

//Vue.use(VueAxios, axios);



const router = new VueRouter({
    mode: 'history',
    routes,
});

Vue.router = router

new Vue({
    el: '#app',
    router,
    store,
    render: h => h(App),
    created() {
        try {
            auth.refresh()
        } catch (err) {
            // Do nothing :))
        }
    }
}).$mount('#app');
