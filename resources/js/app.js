require('./bootstrap');
//require('alpinejs');

import 'es6-promise/auto'
import Vue from 'vue';
import App from './App.vue';
import router from './router';
//import store from "./store/index";

// Load plugins
import "./plugins";


//Vue.router = router
//App.router = Vue.router

const app = new Vue({
    router,
    //store,
    render: app => app(App)
}).$mount("#app");
