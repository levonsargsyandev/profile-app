import Vue from 'vue'
import VueRouter from 'vue-router';
import Dashboard from "./pages/Dashboard";
import Login from "./pages/Login";
import Register from "./pages/Register";
import Home from "./pages/Home";

Vue.use(VueRouter);

const routes = [
    {
        path:'/',
        component:Home
    },
    {
        path:'/dashboard',
        component:Dashboard
    },
    {
        path:'/login',
        component:Login
    },
    {
        path:'/register',
        component:Register
    }
];

const router = new VueRouter({
    mode: 'history',
    base: process.env.BASE_URL,
    routes
});

export default router;
