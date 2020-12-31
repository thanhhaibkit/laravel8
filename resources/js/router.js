import Vue from "vue";
import VueRouter from "vue-router";

Vue.use(VueRouter);

// Routes
const routes = [
    {
        path: '/dashboard',
        name: 'dashboard',
        component: () => import("./components/Dashboard.vue")
    },
    {
        path: "/login",
        component: () => import("./components/authentication/login/User.vue"),
        meta: {
            auth: false
        }
    }
];

const router = new VueRouter({
    history: true,
    mode: 'history',
    routes,
});

export default router;
