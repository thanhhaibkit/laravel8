import Vue from "vue";
import Router from "vue-router";

Vue.use(Router);

export default new Router({
    mode: "history",
    scrollBehavior(to, from, savedPosition) {
        return { x: 0, y: 0 };
    },
    routes: [
        {
            path: '/dashboard',
            name: 'dashboard',
            component: () => import("./components/Dashboard.vue")
        },
        {
            path: "/login",
            component: () => import("./components/authentication/login/User.vue")
        }
    ]
})
