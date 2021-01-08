import Vue from 'vue';
import router from '../router';

import VueAuth               from '@websanova/vue-auth/dist/v2/vue-auth.esm.js';
import driverAuthBearer      from '@websanova/vue-auth/dist/drivers/auth/bearer.esm.js';
import driverHttpAxios       from '@websanova/vue-auth/dist/drivers/http/axios.1.x.esm.js';
import driverRouterVueRouter from '@websanova/vue-auth/dist/drivers/router/vue-router.2.x.esm.js';

/**
 * Authentication configuration, some of the options can be override in method calls
 */
const auth = {
    plugins: {
        http: Vue.axios, // Axios
        // http: Vue.http, // Vue Resource
        router: router,
    },
    drivers: {
        auth: driverAuthBearer,
        http: driverHttpAxios,
        router: driverRouterVueRouter,

    },
    options: {
        rolesKey: 'type',
        notFoundRedirect: {name: 'user-account'},
    }
}

Vue.use(VueAuth, auth);
