require('./bootstrap');
//require('alpinejs');

import Vue from 'vue';
import App from './App.vue';
import router from './router';
//import store from "./store/index";
import axios from 'axios'
import VueAxios from 'vue-axios'

//Vue.use(VueAxios, axios)
//axios.defaults.baseURL = `${process.env.MIX_APP_URL}/api/v1.0`

const app = new Vue({
    router,
    //store,
    render: app => app(App)
}).$mount("#app");
