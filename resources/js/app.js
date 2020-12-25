require('./bootstrap');
//require('alpinejs');

import Vue from 'vue';
import App from './App.vue';
//import router from './router';
//import store from "./store/index";

const app = new Vue({
    //router,
    //store,
    render: app => app(App)
}).$mount("#app");
